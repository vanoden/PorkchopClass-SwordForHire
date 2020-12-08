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
						id NOT NULL AUTOINCREMENT PRIMARY KEY,
						image
					";
				if (! $this->executeSQL($create_table_query)) {
					$this->error = "SQL Error creating game_tiles table in ".$this->module."::Schema::upgrade(): ".$this->error;
					app_log($this->error, 'error');
					return false;
				}

				# Map Grid
				$create_table_query = "
					CREATE TABLE IF NOT EXISTS `game_cells` (
						x			INT(11) NOT NULL,
						y			INT(11) NOT NULL,
						z			INT(11) NOT NULL,
						tile_up		VARCHAR(100),
						tile_down	VARCHAR(100),
						tile_north	VARCHAR(100),
						tile_south	VARCHAR(100),
						tile_east	VARCHAR(100),
						tile_west	VARCHAR(100),
						note		TEXT,
						data		TEXT,
						PRIMARY KEY `pk_grid` (`z`,`x`,`y`),
					)
				";
				if (! $this->executeSQL($create_table_query)) {
					$this->error = "SQL Error creating game_cells table in ".$this->module."::Schema::upgrade(): ".$this->error;
					app_log($this->error, 'error');
					return false;
				}

				# Character Classes
				$create_table_query = "
					CREATE TABLE IF NOT EXISTS `game_character_classes` (
						id			INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
						name		varchar(255) NOT NULL,
					)
				";
				if (! $this->executeSQL($create_table_query)) {
					$this->error = "SQL Error creating geography_provinces table in ".$this->module."::Schema::upgrade(): ".$this->error;
					app_log($this->error, 'error');
					return false;
				}

				$this->setVersion(1);
				$GLOBALS['_database']->CommitTrans();
			}
			return true;
		}
	}
