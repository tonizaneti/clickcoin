import mysql.connector
import config


# Conectar ao banco de dados MySQL usando os dados do arquivo config.py
conn = mysql.connector.connect(
    host=config.MYSQL_HOST,
    user=config.MYSQL_USER,
    password=config.MYSQL_PASSWORD,
    database=config.MYSQL_DATABASE
)

cursor = conn.cursor()

ativos = [
    (1,'BTC','Bitcoin', 0.005),
    (2, 'ETH','Ethereun', 0.02),
    (3, 'SOL','Solana', 1),
]

sql = "insert into ativosp (id, codigo, nome, quantidade) values(%s,%s,%s,%s)"

cursor.executemany(sql, ativos)

conn.commit()
cursor.close()
conn.close()

print('Dados Inseridos com Sucesso!')