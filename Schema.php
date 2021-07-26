<?php
	namespace TileGame;

	class Schema Extends \Database\BaseSchema {
		public $module = "Game";

		public function upgrade() {
			$this->error = null;

			if ($this->version() < 1) {
				app_log("Upgrading schema to version 1",'notice',__FILE__,__LINE__);

				# Start Transaction
				if (! $GLOBALS['_database']->BeginTrans())
					app_log("Transactions not supported",'warning',__FILE__,__LINE__);

				# Tiles (Wall/Floor Faces)
				$create_table_query = "
					CREATE TABLE IF NOT EXISTS `game_tiles` (
						id			INT(11) NOT NULL AUTOINCREMENT PRIMARY KEY,
						type		VARCHAR(255) NOT NULL,
						facing 		enum('up','down','north','south','east','west') NOT NULL',
						fill		VARCHAR(255) NOT NULL
					)
				";
				if (! $this->executeSQL($create_table_query)) {
					$this->error = "SQL Error creating game_tiles table in ".$this->module."::Schema::upgrade(): ".$this->error;
					app_log($this->error, 'error');
					return false;
				}

				# Map Grid
				$create_table_query = "
					CREATE TABLE IF NOT EXISTS `game_cells` (
						id			INT(11) NOT NULL AUTOINCREMENT PRIMARY KEY,
						x			INT(11) NOT NULL,
						y			INT(11) NOT NULL,
						z			INT(11) NOT NULL,
						id_up		INT(11) NOT NULL,
						id_down		INT(11) NOT NULL,
						id_north	INT(11) NOT NULL,
						id_south	INT(11) NOT NULL,
						id_east		INT(11) NOT NULL,
						id_west		INT(11) NOT NULL,
						note		TEXT,
						data		TEXT,
						PRIMARY KEY `pk_grid` (`z`,`x`,`y`),
						FOREIGN KEY `fk_id_up` (`id_up`) REFERENCES `game_tiles` (`id`),
						FOREIGN KEY `fk_id_down` (`id_down`) REFERENCES `game_tiles` (`id`),
						FOREIGN KEY `fk_id_north` (`id_north`) REFERENCES `game_tiles` (`id`),
						FOREIGN KEY `fk_id_south` (`id_south`) REFERENCES `game_tiles` (`id`),
						FOREIGN KEY `fk_id_east` (`id_east`) REFERENCES `game_tiles` (`id`),
						FOREIGN KEY `fk_id_west` (`id_west`) REFERENCES `game_tiles` (`id`),
					)
				";
				if (! $this->executeSQL($create_table_query)) {
					$this->error = "SQL Error creating game_cells table in ".$this->module."::Schema::upgrade(): ".$this->error;
					app_log($this->error, 'error');
					return false;
				}

				# Parties of characters or monsters, stashes or specials
				$create_table_query = "
					CREATE TABLE IF NOT EXISTS `game_collections` (
						id			INT(11) NOT NULL AUTOINCREMENT PRIMARY KEY,
						x			INT(11) NOT NULL,
						y			INT(11) NOT NULL,
						z			INT(11) NOT NULL,
						facing		enum('north','south','east','west','up','down') NOT NULL DEFAULT 'west',
						type		enum('party','stash','special') NOT NULL DEFAULT 'stash',
						INDEX pos(`z,`x`,`y`)
					)
				";
				if (! $this->executeSQL($create_table_query)) {
					$this->error = "SQL Error creating game_cells table in ".$this->module."::Schema::upgrade(): ".$this->error;
					app_log($this->error, 'error');
					return false;
				}

				# Things
				$create_table_query = "
					CREATE TABLE IF NOT EXISTS `game_things` (
						id			INT(11) NOT NULL AUTOINCREMENT PRIMARY KEY,
						collection_id	INT(11) NOT NULL,
						type		VARCHAR(32) NOT NULL,
						class		VARCHAR(32) NOT NULL,
						FOREIGN KEY `fk_stash_id` (`collection_id`) REFERENCES `game_collections` (`id`)
					)
				";
				if (! $this->executeSQL($create_table_query)) {
					$this->error = "SQL Error creating game_cells table in ".$this->module."::Schema::upgrade(): ".$this->error;
					app_log($this->error, 'error');
					return false;
				}

				# Thing Attributes
				$create_table_query = "
					CREATE TABLE IF NOT EXISTS `game_thing_attributes` (
						thing_id	INT(11) NOT NULL,
						`key`		VARCHAR(64),
						value		VARCHAR(255),
						PRIMARY KEY `pk_being_att` (`being_id`,`key`,`value`),
					)
				";
				if (! $this->executeSQL($create_table_query)) {
					$this->error = "SQL Error creating thing_attributes table in ".$this->module."::Schema::upgrade(): ".$this->error;
					app_log($this->error, 'error');
					return false;
				}

				# Thing Inventory
				$create_table_query = "
					CREATE TABLE IF NOT EXISTS `game_thing_inventory` (
						parent_id	INT(11) NOT NULL,
						child_id	INT(11) NOT NULL,
						UNIQUE KEY `uk_thing_inventory` (`parent_id`,`child_id`)
					)
				";
				if (! $this->executeSQL($create_table_query)) {
					$this->error = "SQL Error creating thing_inventory table in ".$this->module."::Schema::upgrade(): ".$this->error;
					app_log($this->error, 'error');
					return false;
				}

				$this->setVersion(1);
				$GLOBALS['_database']->CommitTrans();
			}
			return true;
		}
	}
