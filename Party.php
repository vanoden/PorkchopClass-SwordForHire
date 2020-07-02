<?php
	namespace TileGame;

	class Party Extends Thing {
		private type = 'enemy';
		private _x = 0;
		private _y = 0;
		private _z = 0;
		private _direction = 'N';

		public function members {
			$members = array();

			return $members;
		}

		public function speed {
			# Loop Through Members
			# Return lowest speed

			$speed = 0;

			$members = $this->members();
			foreach($members as $member) {
				$mem_speed = $member->speed();
				if ($speed == 0) $speed = $mem_speed;
				elseif ($speed > $mem_speed) $speed = $mem_speed;
			}
			return $speed;
		}
	}
