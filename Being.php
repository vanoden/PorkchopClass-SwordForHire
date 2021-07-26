<?php
	namespace TileGame;

	class Being Extends Thing {
		private attributes = array();

		public function __construct($id = null) {
			if (isset($id)) {
				$this->details();
			}
		}

		public function totalWeight() {
			return $this->weight() + $this->burden();
		}

		public function speed() {
			$speed = $this->attributes['dexterity'] - ($this->totalWeight()/20);
		}

		public function burden() {
			$weight = 0;
			$inventory = $this->inventory();
			for($i = 0; $i < length($inventory); $i ++) {
				$weight += $inventory[$i]->weight();
			}
			return $weight;
		}

		public function hit_points() {
			return $this->attributes['total_hit_points'] - $this->attributes['damage'];
		}

		public function equip($where,$what) {
			
		}

		public function equiped($where) {
			
		}

		public function morality() {
			if (! isset($this->attributes['morality'])) $this->details();
			return $this->attributes['morality'];
		}

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
