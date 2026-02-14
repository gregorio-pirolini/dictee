
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
'athlète', 
'diarrhée', 
'bonhomme', 
'cathédrale', 
'envahir', 
'labyrinthe', 
'méthode', 
'orthographe', 
'panthère', 
'rhume', 
'rythme', 
'silhouette', 
'souhait', 
'adhérer',
'chauffeur',
'chronique',
'cohérence',
'philosophie',
'psychologie',
'architecture',
'orchestre',
'archaïque',
'esthétique',
'hypothèse',
'pathologie',
'sympathique',
'authentique',
'ahurissant',
'cohabiter',
'inhabituel',
'malhonnête',
'déshabiller'
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
    level = "K"
    folder = "mots/K"

    cur.execute(
        "INSERT INTO words (id, word, folder, level) VALUES (%s, %s, %s, %s)",
        (None, word, folder, level)
    )

conn.commit()
cur.close()
conn.close()