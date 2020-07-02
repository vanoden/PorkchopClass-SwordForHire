<?php
	namespace TileGame;

	class Being {
		public $strength;
		public $intelligence;
		public $wisdom;
		public $charisma;
		public $dexterity;
		public $constitution;
		public $race_id;
		public $class_id;
		public $total_hit_points;
		public $damage = 0;

		public function speed() {
			$speed = $this->dexterity;
		}

		public function hit_points() {
			return $this->total_hit_points - $this->damage;
		}

		public function equip($where,$what) {
			
		}

		public function equiped($where) {
			
		}
	}
