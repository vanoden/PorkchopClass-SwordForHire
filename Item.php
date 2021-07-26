<?php
	namespace TileGame;

	class Item Extends Thing {
		public $id;
		public $class;			# Weapon, Armor, Tool
		public $weight;
		public $durability;
		public $wear;
		public $title;
	}
