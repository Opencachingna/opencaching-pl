--
-- There are a few unused tables which probably can be safety removed.
--

--
-- chat is no more supported
--
DROP TABLE ajax_chat_bans;
DROP TABLE ajax_chat_invitations;
DROP TABLE ajax_chat_messages;
DROP TABLE ajax_chat_online;
DROP TABLE ajax_chat_users;

--
-- caches_memory is never used in code
--
DROP TABLE caches_memory;

--
-- cache_loc is never used in code now
--
DROP TABLE cache_loc;

--
-- cache_maps is never used in code now
--
DROP TABLE cache_maps;

--
-- logins is never used in code now
--
DROP TABLE logins;

--
-- log_rating was used only in never display statistic
--
DROP TABLE log_rating;

