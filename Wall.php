<?php
	namespace TileGame;

	class Wall {
		public $x = 0;
		public $y = 0;
		public $z = 0;
		public $direction = 'N';

		public function is($x,$y,$z,$dir) {
			$this->x = $x;
			$this->y = $y;
			$this->z = $z;
			$this->direction = $dir;
		}
	}
