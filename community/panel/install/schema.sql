PRAGMA foreign_keys=ON;
CREATE TABLE IF NOT EXISTS users(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT NOT NULL UNIQUE,
  password_hash TEXT NOT NULL,
  role TEXT NOT NULL DEFAULT 'admin',
  active INTEGER NOT NULL DEFAULT 1,
  last_login_at TEXT,
  created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS settings(key TEXT PRIMARY KEY,value TEXT NOT NULL DEFAULT '');
CREATE TABLE IF NOT EXISTS portals(id INTEGER PRIMARY KEY AUTOINCREMENT,url TEXT NOT NULL UNIQUE,enabled INTEGER NOT NULL DEFAULT 1,created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS devices(id INTEGER PRIMARY KEY AUTOINCREMENT,device_id TEXT NOT NULL UNIQUE,device_username TEXT NOT NULL DEFAULT '',last_seen_at TEXT,created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS reports(id INTEGER PRIMARY KEY AUTOINCREMENT,username TEXT,macaddress TEXT,section TEXT,section_category TEXT,report_title TEXT,report_sub_title TEXT,report_cases TEXT,report_custom_message TEXT,stream_name TEXT,stream_id TEXT,created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS feedback(id INTEGER PRIMARY KEY AUTOINCREMENT,username TEXT,macaddress TEXT,feedback_content TEXT NOT NULL,created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS announcements(id INTEGER PRIMARY KEY AUTOINCREMENT,title TEXT NOT NULL,message TEXT NOT NULL,created_on TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS announcement_views(announcement_id INTEGER NOT NULL,device_id TEXT NOT NULL,viewed_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY(announcement_id,device_id),FOREIGN KEY(announcement_id) REFERENCES announcements(id) ON DELETE CASCADE);
CREATE TABLE IF NOT EXISTS audit_log(id INTEGER PRIMARY KEY AUTOINCREMENT,action TEXT NOT NULL,ip TEXT,meta_json TEXT,created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP);
INSERT OR IGNORE INTO settings(key,value) VALUES
('site_name','X1 Smarters Community'),
('maintenance_mode','off'),('maintenance_title',''),('maintenance_body',''),
('advertisement_status','off'),('advertisement_viewable_rate',''),('advertisement_message',''),
('intro_url',''),('rate_url','https://google.com'),('update_package','com.titan.smart'),('update_url',''),
('vpn_status','off'),('vpn_profile_url',''),('sports_url',''),('note_message',''),
('community_forum_url','https://forum.x1panel.space'),
('community_telegram_url','https://t.me/+XkuQS_QuD6g4Nzc0'),
('community_discord_url','https://discord.gg/vSSw6jHmw');
