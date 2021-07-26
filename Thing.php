<?php
	namespace TileGame;

	class Thing {
		public $x;
		public $y;
		public $z;

		public function details() {
			$get_details_query = "
				SELECT	*
				FROM	game_beings
                WHERE	id = ?
			";
		}

		public function getAttributes() {
			$get_attributes_query = "
				SELECT	`key`,value
				FROM	game_being_attributes
				WHERE	being_id = ?
			";
		}

		public function attribute($key) {
			if (! isset($this->attributes[$key])) {
				$this->getAttributes();
			}
			return $this->atttributes[$key];
		}

		public function location() {
			$loc = array();
			$loc['x'] = $this->attribute['x'];
			$loc['y'] = $this->attribute['y'];
			$loc['z'] = $this->attribute['z'];
			return $loc;
		}
	}
