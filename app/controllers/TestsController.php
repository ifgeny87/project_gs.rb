<?php

class TestsController extends ControllerBase
{
	public function modelsAction($action = null, $table = null, $id = null, $field = null)
	{
		# get actions
		switch($action) {

			case 'update':
				switch($table) {

					case 'locales':
						$Locale = Locales::findFirst(array(
							'conditions' => 'object_id = ?1',
							'bind' => array(1 => $id)));

						if(!$Locale->count())
							$this->flash->error('Locale have not found');

						else {
							$Locale->$field .= substr(date('s'), -1);
							$r = $Locale->save();

							if(!$r) {
								$msg = implode('</br>', $Locale->getMessages());
								$this->flash->error('Error while save:<br/>'. $msg);
							}
							else
								$this->response->redirect('/tests/models');
						}
						break;

					case 'localetexts':
						$Locale = LocaleTexts::findFirst(array(
							'conditions' => 'object_id = ?1',
							'bind' => array(1 => $id)));

						if(!$Locale->count())
							$this->flash->error('LocalePart have not found');

						else {
							$Locale->$field .= substr(date('s'), -1);
							$r = $Locale->save();

							if(!$r) {
								$msg = implode('</br>', $Locale->getMessages());
								$this->flash->error('Error while save:<br/>'. $msg);
							}
							else
								$this->response->redirect('/tests/models');
						}
						break;
				}
				break;

			case 'insert':
				switch($table) {

					case 'localetexts':
						$Locale = Locales::findFirst(array(
							'conditions' => 'object_id = ?1',
							'bind' => array(1 => $id)));

						if(!$Locale->count())
							$this->flash->error('Locale have not found');

						else {
							$text = new LocaleTexts();
							$text->locales = $Locale;
							$text->key = 'Word';
							$text->text = 'Text is ';
							$r = $text->save();

							if(!$r) {
								$messages = array_merge(
									$text->getMessages(),
									$text->locales->getMessages(),
									$text->objects->getMessages());
								$msg = implode('</br>', $messages);
								$this->flash->error('Error while insert LocaleText:<br/>'. $msg);
							}
							else
								$this->response->redirect('/tests/models');
						}
						break;
				}
				break;
		}

		# post queries
		if($this->request->isPost()) {
			switch($_POST['table']) {

				case 'robots':
					$data = array(
						'prefix' => $_POST['prefix'],
						'name' => $_POST['name']);
					$locale = new Locales();
					$result1 = $locale->create($data);
					if(!$result1) {
						foreach($locale->getMessages() as $msg)
							$this->flash->error($msg);
					}
					else {
						$this->flash->success('New Locale added');
					}
					break;

				case 'systemconfigs':
					$data = array(
						'key' => $_POST['key'],
						'value' => $_POST['value']);
					$config = new SystemConfigs();
					$res = $config->create($data);
					if(!$res) {
						foreach($config->getMessages() as $msg)
							$this->flash->error($msg);
					}
					else {
						$this->flash->success('New System config added');
					}
					break;
			}
		}

		$object_fields = array('id', 'class_name', 'created', 'updated', 'locked');
		$locale_fields = array('prefix', 'name');
		$localetext_fields = array('key', 'text');
		$systemconfig_fields = array('id', 'key', 'value', 'updated');

		#
		#	Objects
		#

		echo '<h2>Objects</h2>';

		echo '<table border=1><tr>';
		foreach($object_fields as $f)
			echo '<th>', $f, '</th>';
		echo '<th>Locales K</th><th>Texts K</th>';
		echo '</tr>';

		foreach(Objects::find() as $v) {
			echo '<tr>';
			foreach($object_fields as $f)
				echo "<td>", $v->$f, "</td>";
			echo '<td>', ($v->Locales === false ? '-' : '+'), '</td>';
			echo '<td>', ($v->LocaleTexts === false ? '-' : '+'), '</td>';
			echo '</tr>';
		}

		echo '</table>';

		#
		#	Locales
		#

		echo '<h2>Locales</h2>';

		echo '<table border=1><tr>';
		echo '<th>#</th>';
		foreach($locale_fields as $f)
			echo '<th>', $f, '</th>';
		echo '<th>Texts K</th>';
		echo '<th>Add text</th>';
		echo '</tr>';

		foreach(Locales::find() as $v) {
			echo '<tr>';
			echo '<td>', $v->objects->id, '</td>';
			foreach($locale_fields as $f)
				echo '<td>',
					$this->tag->linkTo('/tests/models/update/locales/'.$v->objects->id.'/'.$f, $v->$f),
					'</td>';
			echo '<td>', ($v->LocaleTexts->count()), '</td>';
			echo '<td>',
				$this->tag->linkTo('/tests/models/insert/localetexts/'.$v->objects->id, '+'),
				'</td>';
			echo '</tr>';
		}
		
		echo '</table>';

		#
		#	Locale texts
		#

		echo '<h2>Locale texts</h2>';

		echo '<table border=1><tr>';
		echo '<th>#</th>';
		echo '<th>locale id</th>';
		foreach($localetext_fields as $f)
			echo '<th>', $f, '</th>';
		echo '</tr>';

		foreach(LocaleTexts::find() as $v) {
			echo '<tr>';
			echo '<td>', $v->Objects->id, '</td>';
			echo '<td>', $v->Locales->Objects->id, '</td>';
			foreach($localetext_fields as $f)
				echo "<td>",
				$this->tag->linkTo('/tests/models/update/localetexts/'.$v->objects->id.'/'.$f, $v->$f),
				"</td>";
			echo '</tr>';
		}
		
		echo '</table>';

		#
		#	System configs
		#

		echo '<h2>System configs</h2>';

		echo '<table border=1><tr>';
		foreach($systemconfig_fields as $f)
			echo '<th>', $f, '</th>';
		echo '</tr>';

		foreach(SystemConfigs::find() as $v) {
			echo '<tr>';
			foreach($systemconfig_fields as $f)
				echo "<td>", $v->$f, "</td>";
			echo '</tr>';
		}
		
		echo '</table>';
	}

	public function bootstrapAction()
	{
		$this->view->setTemplateAfter('bootstrap');
	}
}