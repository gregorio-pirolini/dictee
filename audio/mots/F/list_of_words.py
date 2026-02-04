import os
import re
import time
import unicodedata
from pathlib import Path

import requests


API_BASE = "https://api.soundoftext.com"
VOICE = "fr-FR"  # French (France)

# !Mots avec â

# arête (de poisson)
# bâbord
# bâillement
# châssis
# châtiment
# dégât
# gâcher
# hâte
# mâcher
# marâtre
# relâche

#! Mots avec ê

# apprêt

# bêche

# carême

# fêlure

# genêt

# grêle

# honnête

# pêche

# quête

# rêve

# trêve

# salpêtre

# enquête

# guêpe
# intérêt
# poêle

#! # //Mots avec ô

# aussitôt

# bientôt

# chômage

# contrôle

# côtoyer

# enjôleur

# tantôt

# entrepôt

# frôler

# geôle

# impôt

# ôter

# plutôt

# pylône

# rôle

# tôle

# tôt





# WORDS = [

# "bateau",
# "chapitre",
# "havre",
# "javelot",
# "matelot",
# "pavot",
# "racler",
# ]


WORDS = ["arène",
         "solfège",
         "prétendre",
         "poème",
         "barème",
         "blasphème",
           "brèche",
           "fève",
           "crèche",
           "emblème",
           "crème"]
# WORDS_O = ["complot",
# "bohème", fantôme, frôler
#     "théorème",
#     "toit",
#     "tricot",
# "trot",
#     "zone","argot",
# "atome",
# "axiome","hublot","chrome","cyclone",
 
# "dévot",
# "dose",]

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