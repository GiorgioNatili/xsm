cd "%0\..\..\.."

bin\db\sqlite3 -header -csv tmp\trial-bft.sqlite "select * from BFT;" > tmp/dump.csv

pause