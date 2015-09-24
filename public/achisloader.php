<?php
/*
TRUNCATE `achis_achievements`;
TRUNCATE `achis_applications`;
TRUNCATE `achis_tasks`;
TRUNCATE `achis_user_achievements`;
TRUNCATE `achis_user_applications`;
INSERT INTO `achis.dev87.ru`.`achis_tasks` (`id`, `user_id`, `application_id`, `work_type`, `status`, `priority`, `try_count`, `try_count_max`, `created`, `updated`) VALUES
(NULL, '1', NULL, 'update_user_recently', 'wait', '0', '0', '3', CURRENT_TIMESTAMP, NULL)
,(NULL, '2', NULL, 'update_user_recently', 'wait', '0', '0', '3', CURRENT_TIMESTAMP, NULL)
,(NULL, '3', NULL, 'update_user_recently', 'wait', '0', '0', '3', CURRENT_TIMESTAMP, NULL)
,(NULL, '4', NULL, 'update_user_recently', 'wait', '0', '0', '3', CURRENT_TIMESTAMP, NULL)
,(NULL, '5', NULL, 'update_user_recently', 'wait', '0', '0', '3', CURRENT_TIMESTAMP, NULL);
*/

/**
 *  loader.php
 *
 * @autor Makarov Evgeny <ifgeny87@gmail.com>
 * @link http://dev87.ru
 * @version 2015-07-16 08:18
 */

use \Phalcon\Mvc\Application;
use \Phalcon\Config\Adapter\Ini as ConfigIni;
use \Achis\Models\Applications as AchisApplications;
use \Achis\Models\Users as AchisUsers;
use \Achis\Models\UserApplications as AchisUserApplications;
use \Achis\Models\Tasks as AchisTasks;

//
// проверяю ip-адрес запустившего на доступность
//
error_reporting(0);
ini_set('display_errors', 0);

($ip = $_SERVER['HTTP_X_REAL_IP'])
|| ($ip = $_SERVER['HTTP_X_FORWARDED_FOR'])
|| ($ip = $_SERVER['REMOTE_ADDR']);

$avail_ips = array('127.0.0.1');
# $_SERVER['argc'] - количество параметров переданое при запуске в консоли
# $_SERVER['argc'] будет только если запущено из консоли
if(in_array($ip, $avail_ips) !== true && !isset($_SERVER['argc'])) {
	header("HTTP/1.1 403 Unauthorized");
	die("Forbidden for {$ip}\n");
}

//
// тест на ip-адрес пройден
// выполняю основную работу
//
define('LOAD_ACCESS', time());
//
// локалью меняю
//
mb_regex_encoding('UTF-8');
setlocale(LC_ALL, 'ru_RU.UTF-8');
//
// настраиваю вывод ошибок
//
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 'On');
//
// формат вывода
//
header('Content-type: text/plain');
//
// папка приложения
//
define('APP_PATH', realpath(__DIR__.'/..') . '/');

try {
	// Read config, auto-loader, services, handle the application
	$config = new ConfigIni(APP_PATH . 'app/config/config.ini');
	require APP_PATH . 'app/config/loader.php';
	require APP_PATH . 'app/config/services.php';
	$program = new Application($di);

	# регистрирую новый компонент
	$di->set('achis', function() {
		return new AchisDataGetter();
	});

	$di->set('collectionManager', '\Phalcon\Mvc\Collection\Manager');

	//
	// выполняю работу приложения
	//

	#
	#	Пробую получить задание
	#

	# 1. Сначала пробую получить текущее задание (статус = "work")
	$task = AchisTasks::findFirst(array(
		'conditions' => 'status = ?0',
		'bind' => array(AchisTasks::STATUS_WORK)));
	# Если задание есть, проверяю количество ошибок
	if($task !== false) {
		if($task->try_count >= $task->try_count_max) {
			# закрываю задание как неуспешное
			$task->save(array('status' => AchisTasks::STATUS_ERROR));
			$task = false;
		}
	}

	# 2. Если задания нет, пробую получить задание по приоритету (статус = "wait")
	# Это должно быть более раннее задание
	if($task === false) {
		$task = AchisTasks::findFirst(array(
			'order' => 'priority DESC, created, id',
			'conditions' => 'status = ?0',
			'bind' => array(AchisTasks::STATUS_WAIT)));

		# если нашел задание, ставлю его в работу
		if($task !== false) {
			$task->save(array('status' => AchisTasks::STATUS_WORK));
		}
	}

	# 3. Если нет невыполненных заданий, создаю новое задание
	# Просто выбираю самое старшее задание по игрокам на обновление недавних игр
	if($task === false) {
		// SELECT `user_id` , max( `updated` ) AS `updated1`
		// FROM `achis_tasks`
		// WHERE `work_type` = 'update_user_recently'
		// GROUP BY `user_id`
		// ORDER BY `updated1`
		$list = $program->modelsManager->createQuery(
			"SELECT user_id, max(updated) as updated1
			 FROM \Achis\Models\Tasks
			 WHERE work_type = 'update_user_recently'
			 GROUP BY user_id
			 ORDER BY updated1")->execute()->toArray();
		# если задание было найдено, создаю новую задачу на обновление игры
		if(count($list) > 0) {
			$user = AchisUsers::findFirst($list[0]['user_id']);
			$task = AchisTasks::createUpdateUserRecently($user);
		}
		
		# параллельно также создаю задание на обновление ачивок в какой-нибудь игре
		// SELECT `application_id`, max(`updated`) as `updated1`
		// FROM `achis_tasks` 
		// WHERE `work_type` = 'update_game_achivs'
		// GROUP BY `application_id`
		// ORDER BY `updated1`
		$list = $program->modelsManager->createQuery(
			"SELECT application_id, max(updated) as updated1
			 FROM \Achis\Models\Tasks
			 WHERE work_type = 'update_game_achivs'
			 GROUP BY application_id
			 ORDER BY updated1")->execute()->toArray();
		# если задание было найдено, создаю новую задачу на обновление игры
		if(count($list) > 0) {
			$app = AchisApplications::findFirst($list[0]['application_id']);
			AchisTasks::createUpdateGameAchivs($app);
		}
		
		# но сейчас не буду его выполнять
		#if($task2 !== false) {
		#	AchisTasks::createUpdateGameAchivs($task2->app);
		#}
	}

	# 4. Если все еще нет задачи, вывожу соответствующее сообщение и завершаю работу
	if($task === false) {
		echo "No task found\n";
		die;
	}

	#
	#	Задание есть, выполняю
	#

	echo "Run task #{$task->id} '{$task->work_type}' for user #{$task->user->id} '{$task->user->name}' and app #{$task->app->id} '{$task->app->name}'\n";

	# приращиваю значение попыток
	$task->update(array('try_count' => $task->try_count+1));

	# по типу задания выполняю действие
	switch($task->work_type) {
		case AchisTasks::TASK_UPDATE_USER_GAME_ACHIVS:
			$program->achis->updateUserGameAchivs($task);
			break;

		case AchisTasks::TASK_UPDATE_USER_GAMES:
			$program->achis->updateUserGames($task);
			break;

		case AchisTasks::TASK_UPDATE_USER_RECENTLY:
			$program->achis->updateUserRecently($task);
			break;

		case AchisTasks::TASK_UPDATE_GAME_ACHIVS:
			$program->achis->updateGameAchivs($task);
			break;

		default:
			throw new \Exception("Unknown task work_type '{$task->work_type}'");
	}

	# считаю задание выполненным
	$task->update(array('status' => AchisTasks::STATUS_SUCCESS));

	echo "Done\n";
} 
catch (\Exception $e) {
	$error = '[E_ERROR] ' . $e->getMessage();
	$warning = '[E_USER_ERROR] Stacktrace:' . "\n" . $e->getTraceAsString();

	// want E_ERROR
	if(error_reporting() & E_ERROR)
		echo "\n", $error, "\n";

	// want E_USER_ERROR
	if(error_reporting() & E_USER_ERROR)
		echo "\n", $warning, "\n";

	# logging
	$dir = APP_PATH . 'logs/';
	if(!is_dir($dir)) {
		if(error_reporting() & E_ERROR)
			echo "\n\n", '[E_ERROR] logs folder no exists';
	}
	else {
		$name = explode('/', __FILE__);
		$name = array_pop($name);
		$fileName = $name . date('_Ymd') . '_errors.log';
		$data = file_get_contents($dir.$fileName);
		if($data != null)
			$data .= "\n\n";
		$data .= '======== [' . date('Y-m-d H:i:s') . "] ======================\n";
		$data .= $error . "\n" . $warning;
		file_put_contents($dir.$fileName, $data);
	}
}