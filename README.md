В данном каталоге представлен сайт-курсовая по продаже велосипедов.

ВНИМАНИЕ!
Чтобы запустить сайт у себя: 
1. Удалите старую версию myDB_kurs.sql.
2. Переименнуйте актуальную версию дампа на myDB_kurs.sql и в начале этого файла напишите:
  CREATE DATABASE IF NOT EXISTS myDB_kurs;
  USE myDB_kurs;

2.Откройте Docker Desktop -> Терминал -> cd (Путь к папке проекта) -> docker-compose up --build -d

Теперь проект должен открываться на locahost:80, phpMyAdmin на localhost:8080 (данные для входа root - root, либо user - password)
Админские учетные данные для панели админа сайта: admin - 123
