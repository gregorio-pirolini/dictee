import os
import re
import time
import unicodedata
from pathlib import Path
import requests

# https://vitrinelinguistique.oqlf.gouv.qc.ca/23722/lorthographe/problemes-lies-aux-consonnes/les-graphies-possibles-du-son-s
API_BASE = "https://api.soundoftext.com"
VOICE = "fr-FR"  # French (France)









WORDS= [ 
'chauffeurr'



# mot en -emment -ammant
# mot en -tion et -ssion
# mot avec double consonnes
    # mots commençant par H  
    # H à l'intérieur d un mot
# mot avec double voyelle
#e accent ou e double consonne
# ill ou y  https://www.francaisfacile.com/exercices/exercice-francais-2/exercice-francais-100448.php
  ]

OUT_DIR = Path("soundoftext_mp3")
OUT_DIR.mkdir(parents=True, exist_ok=True)


def safe_filename(s: str) -> str:
    # Keep accents but make a filesystem-safe name; also remove weird punctuation
    s = unicodedata.normalize("NFC", s).strip()
    s = re.sub(r"[^\w\s\-']", "_", s, flags=re.UNICODE)
    s = re.sub(r"\s+", "_", s)
    return s[:120] if len(s) > 120 else s


def request_sound(text: str, voice: str) -> str:
    payload = {"engine": "Google", "data": {"text": text, "voice": voice}}
    r = requests.post(f"{API_BASE}/sounds", json=payload, timeout=30)
    r.raise_for_status()
    data = r.json()
    if not data.get("success"):
        raise RuntimeError(f"API error for {text!r}: {data}")
    return data["id"]


def wait_for_location(sound_id: str, timeout_s: int = 90, poll_every_s: float = 1.5) -> str:
    deadline = time.time() + timeout_s
    while time.time() < deadline:
        r = requests.get(f"{API_BASE}/sounds/{sound_id}", timeout=30)
        r.raise_for_status()
        data = r.json()

        status = data.get("status")
        if status == "Done" and data.get("location"):
            return data["location"]
        if status == "Error":
            raise RuntimeError(f"Sound generation failed: {data}")

        time.sleep(poll_every_s)

    raise TimeoutError(f"Timed out waiting for sound {sound_id}")


def download_mp3(url: str, dest: Path) -> None:
    with requests.get(url, stream=True, timeout=60) as r:
        r.raise_for_status()
        with open(dest, "wb") as f:
            for chunk in r.iter_content(chunk_size=1024 * 128):
                if chunk:
                    f.write(chunk)


def main():
    for word in WORDS:
        print(f"==> Creating: {word}")
        sound_id = request_sound(word, VOICE)
        location = wait_for_location(sound_id)
        filename = f"{safe_filename(word)}.mp3"
        dest = OUT_DIR / filename
        download_mp3(location, dest)
        print(f"Saved: {dest}")

    print("All done.")


if __name__ == "__main__":
    main()