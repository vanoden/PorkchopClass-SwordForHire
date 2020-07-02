<?php
	namespace TileGame;

	class Thing {
		public $x;
		public $y;
		public $z;

		public function location() {
			$location = new Location();
			$location->is($this->x,$this->y,$this->z);
			return $location;
		}
	}
