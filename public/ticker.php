<?php

// set_time_limit(3600);

// while (true) {

	// work on events
	$db = DBManager::get()->query("SELECT * FROM lis_events WHERE end <= UNIX_TIMESTAMP(NOW())");

	while ($data = $db->fetch()) {
		switch ($data['type']) {
			case 'build':			
				echo 'creating building...<br>';
				$planet_id   = $data['range_id'];
				$building_id = $data['sec_range_id'];

				// increase building-level
				if (DBManager::get()->query("SELECT COUNT(*) FROM lis_planets_buildings 
					WHERE planet_id = $planet_id AND building_id = $building_id")->fetchColumn()) {

					DBManager::get()->query("UPDATE lis_planets_buildings SET level = level + 1
						WHERE planet_id = $planet_id AND building_id = $building_id");
				} else {
					DBManager::get()->query("INSERT INTO lis_planets_buildings (planet_id, building_id, level)
						VALUES ($planet_id, $building_id, 1)");
				}
			break;


			case 'tick':
				echo 'starting ticker...<br>';
				// add resources to planets
				$db = DBManager::get()->query(" SELECT lp.*,
				
						(SELECT SUM(b.mod_storage * pb.level) FROM lis_planets_buildings pb
							LEFT JOIN lis_buildings b USING (building_id)
						WHERE planet_id = lp.planet_id AND pb.active = 1) as storage,
						
						(SELECT SUM(b.mod_carboxin * pb.level) FROM lis_planets_buildings pb
							LEFT JOIN lis_buildings b USING (building_id)
						WHERE planet_id = lp.planet_id AND pb.active = 1) as pcarboxin,
						
						(SELECT SUM(b.mod_detrogen * pb.level) FROM lis_planets_buildings pb
							LEFT JOIN lis_buildings b USING (building_id)
						WHERE planet_id = lp.planet_id AND pb.active = 1) as pdetrogen,
						
						(SELECT SUM(b.mod_radium * pb.level) FROM lis_planets_buildings pb
							LEFT JOIN lis_buildings b USING (building_id)
						WHERE planet_id = lp.planet_id AND pb.active = 1) as pradium,
						
						(SELECT SUM(b.mod_credits * pb.level) FROM lis_planets_buildings pb
							LEFT JOIN lis_buildings b USING (building_id)
						WHERE planet_id = lp.planet_id AND pb.active = 1) as pcredits

					FROM lis_planets lp				
					WHERE owner_id != 0");
				
				while ($planet = $db->fetch()) {	
					$storage  =$planet['storage'];
					if (!$storage) $storage = 0;
					
					// every planet has a standard storage capacity of 5000 and generates 10000 credits;
					$storage += 5000;
					$planet['credits'] += 5000;
					$planet['pcarboxin'] += 250;
					$planet['pradium'] += 25;
					$planet['pdetrogen'] += 150;
					
					foreach (Config::get('resources') as $res) {
						if ($res != 'energy') {
							$$res = $planet[$res] + $planet['p'. $res];
							
							if ($res == 'credits') {
								if ($planet[$res] + $planet['p'. $res] > $storage * 10) $$res = $storage * 10;
							} else {
								if ($planet[$res] + $planet['p'. $res] > $storage) $$res = $storage;
							}
							
							if (($planet[$res] + $planet['p'. $res]) < 0) {
								Planets::deactivateBuildingsByUsage($res, $planet['planet_id']);
								$$res = 0;
							}
						}
					}
					
					DBManager::get()->query("UPDATE lis_planets
						SET carboxin = $carboxin, detrogen = $detrogen, radium = $radium, credits = $credits
						WHERE planet_id = ". $planet['planet_id']);
						
					if (Planets::getEnergy($planet['planet_id']) < 0) {
						Planets::deactivateBuildingsByUsage('energy', $planet['planet_id']);
					}
				}

				DBManager::get()->query("INSERT INTO lis_events (type, end)
					VALUES ('tick', ". (time() + 120) .")");
			break;
		}

		// event done, remove event from event-table
		DBManager::get()->query("DELETE FROM lis_events WHERE event_id = ". $data['event_id']);
	}

	// sleep(10);
// }
