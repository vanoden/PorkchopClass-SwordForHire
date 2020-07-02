<?php
	namespace TileGame;

	class Schema Extends \Database\BaseSchema {
		public $module = "TileGame";

		public function upgrade() {
			$this->error = null;

			if ($this->version() < 1) {
				app_log("Upgrading schema to version 1",'notice',__FILE__,__LINE__);

				# Start Transaction
				if (! $GLOBALS['_database']->BeginTrans())
					app_log("Transactions not supported",'warning',__FILE__,__LINE__);

				# Map Grid
				$create_table_query = "
					CREATE TABLE IF NOT EXISTS `tilegame_tiles` (
						x			INT(11) NOT NULL,
						y			INT(11) NOT NULL,
						z			INT(11) NOT NULL,
						img_flor	VARCHAR(100),
						img_ceil	VARCHAR(100),
						img_left	VARCHAR(100),
						img_rght	VARCHAR(100),
						img_frnt	VARCHAR(100),
						img_back	VARCHAR(100),
						note		TEXT,
						data		TEXT,
						PRIMARY KEY `pk_grid` (`z`,`x`,`y`),
					)
				";
				if (! $this->executeSQL($create_table_query)) {
					$this->error = "SQL Error creating tilegame_tiles table in ".$this->module."::Schema::upgrade(): ".$this->error;
					app_log($this->error, 'error');
					return false;
				}

				# Character Classes
				$create_table_query = "
					CREATE TABLE IF NOT EXISTS `tilegame_character_classes` (
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
