<?php
	namespace TileGame;

	class Party {
		public function members {
			# Get Beings with matching collection id from database
			$members = array();

			$get_members_query = "
				SELECT	id
				FROM	game_collections
				WHERE	id = ?
			";

			return $members;
		}

		public function direction {
			# What direction is the party facing
			$direction = 'north';
			return $direction;
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
