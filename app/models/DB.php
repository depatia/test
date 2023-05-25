<?php
    class DB {
        private static $_db = null;

        public static function getInstance() {
            if (self::$_db == null)
                self::$_db = new PDO('mysql:host=sql311.ultimatefreehost.in;dbname=ltm_34269273_test', 'ltm_34269273', 'q1w2e3r4t5y6');

                return self::$_db;
        }
    }