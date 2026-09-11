<?php
$dbDir=__DIR__.'/data'; if(!is_dir($dbDir)) mkdir($dbDir,0777,true);
$db=new PDO('sqlite:'.$dbDir.'/dvps39.sqlite'); $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$schema=[
'CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY AUTOINCREMENT,name TEXT NOT NULL,email TEXT UNIQUE NOT NULL,password TEXT NOT NULL,role TEXT NOT NULL DEFAULT "employee",department TEXT DEFAULT "Field Operations",photo TEXT,active INTEGER DEFAULT 1,created_at TEXT DEFAULT CURRENT_TIMESTAMP)',
'CREATE TABLE IF NOT EXISTS workplaces(id INTEGER PRIMARY KEY AUTOINCREMENT,name TEXT NOT NULL,latitude REAL NOT NULL,longitude REAL NOT NULL,radius INTEGER NOT NULL DEFAULT 250,shift_start TEXT NOT NULL DEFAULT "09:00",shift_end TEXT NOT NULL DEFAULT "17:00")',
'CREATE TABLE IF NOT EXISTS attendances(id INTEGER PRIMARY KEY AUTOINCREMENT,user_id INTEGER NOT NULL,date TEXT NOT NULL,punch_in TEXT,punch_out TEXT,status TEXT DEFAULT "present",overtime_minutes INTEGER DEFAULT 0,checkin_lat REAL,checkin_lng REAL,checkout_lat REAL,checkout_lng REAL,notes TEXT,UNIQUE(user_id,date))',
'CREATE TABLE IF NOT EXISTS locations(id INTEGER PRIMARY KEY AUTOINCREMENT,user_id INTEGER NOT NULL,latitude REAL NOT NULL,longitude REAL NOT NULL,status TEXT NOT NULL,accuracy REAL,recorded_at TEXT NOT NULL)',
'CREATE TABLE IF NOT EXISTS leave_requests(id INTEGER PRIMARY KEY AUTOINCREMENT,user_id INTEGER NOT NULL,type TEXT NOT NULL,start_date TEXT NOT NULL,end_date TEXT NOT NULL,reason TEXT,status TEXT DEFAULT "pending",manager_comment TEXT,created_at TEXT DEFAULT CURRENT_TIMESTAMP)',
'CREATE TABLE IF NOT EXISTS notifications(id INTEGER PRIMARY KEY AUTOINCREMENT,user_id INTEGER NOT NULL,title TEXT NOT NULL,message TEXT NOT NULL,type TEXT DEFAULT "info",read_at TEXT,created_at TEXT DEFAULT CURRENT_TIMESTAMP)'];
foreach($schema as $s)$db->exec($s);
$users=[['Manager','manager@dvps39.test','password','manager','Operations'],['Rahul Kumar','employee@dvps39.test','password','employee','Field Operations'],['Aisha Khan','aisha@dvps39.test','password','employee','Field Operations'],['Vikram Singh','vikram@dvps39.test','password','employee','Medical Support']];
foreach($users as $u){$st=$db->prepare('INSERT OR IGNORE INTO users(name,email,password,role,department,photo) VALUES(?,?,?,?,?,?)');$photo='assets/avatar-'.strtolower(explode(' ',$u[0])[0]).'.svg';$st->execute([$u[0],$u[1],password_hash($u[2],PASSWORD_DEFAULT),$u[3],$u[4],$photo]);}
$db->exec("INSERT OR IGNORE INTO workplaces(id,name,latitude,longitude,radius,shift_start,shift_end) VALUES(1,'DVPS39 Main Office',17.3850,78.4867,250,'09:00','17:00')");
$db->exec("INSERT OR IGNORE INTO leave_requests(user_id,type,start_date,end_date,reason,status) SELECT id,'remote','2026-09-11','2026-09-11','Approved remote work for field assignment','approved' FROM users WHERE email='aisha@dvps39.test' AND NOT EXISTS(SELECT 1 FROM leave_requests)");
file_put_contents($dbDir.'/.installed','ok'); echo "DVPS39 Attendify setup complete.\nDatabase: data/dvps39.sqlite\nDemo manager: manager@dvps39.test / password\nDemo employee: employee@dvps39.test / password\n";
