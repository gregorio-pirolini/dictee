
import mysql.connector
import sys
print(sys.executable)
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="greg2023",
    database="dictee",
    charset="utf8mb4"
)

cur = conn.cursor()

WORDS= [ 
'amazone',
'argot',
'arôme',
'atome',
'aumône',
'autonome',
'axiome',
'binôme',
'bohème',
'chrome',
'chômage',
'clone',
'clôture',
'complot',
'contrôle',
'cyclone',
'cône',
'côte',
'côtoyer',
'diplôme',
'dose',
'drone',
'drôle',
'dévot',
'dôme',
'enjôleur',
'entrepôt',
'fantôme',
'frôler',
'hippodrome',
'hublot',
'hôpital',
'hôte',
'icône',
'impôt',
'môme',
'neurone',
'ozone',
'pôle',
'rôle',
'silicone',
'tantôt',
'théorème',
'toit',
'tricot',
'trône',
'tôle',
'zone',
'ôter'
  ] 

mysql.connector.connect(
    host="localhost",
    user="root",
    password="greg2023",
    database="dictee",
    charset="utf8mb4"
)

cur = conn.cursor()

for word in WORDS:
    level = "H"
    folder = "mots/H"

    cur.execute(
        "INSERT INTO words (id, word, folder, level) VALUES (%s, %s, %s, %s)",
        (None, word, folder, level)
    )

conn.commit()
cur.close()
conn.close()