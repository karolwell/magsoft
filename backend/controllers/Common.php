<?php
namespace backend\controllers;
use Yii;
use yii\helpers\Url;
use yii\httpclient\Client;
use backend\controllers\Common;
use backend\models\User;
use backend\models\Profile;
use backend\models\Menu;
use backend\models\sousMenu;

/**
 * Description of Common
 *
 * @author Karol Well
 */
class Common {

	public static function getAllcontrolleractions()
	{
		$controllers = \yii\helpers\FileHelper::findFiles(Yii::getAlias('@app/controllers'), ['recursive' => true]);
		$actions = [];
		foreach ($controllers as $controller) {
			$contents = file_get_contents($controller);
			$controllerId = \yii\helpers\Inflector::camel2id(substr(basename($controller), 0, -14));
			preg_match_all('/public function action(\w+?)\(/', $contents, $result);
			foreach ($result[1] as $action) {
				$actionId = \yii\helpers\Inflector::camel2id($action);
				$route = $controllerId . '/' . $actionId;
				$actions[$controllerId][$route] = $route;
			}
		}
		//print_r($actions);exit;
		asort($actions);

		return $actions;
	}

	public static function getControllersandactions()
	{
		$controllerlist = [];
		if ($handle = opendir('../controllers')) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
					$controllerlist[] = $file;
				}
			}
			closedir($handle);
		}
		print_r($controllerlist);exit;
		print_r(asort($controllerlist));exit;
		$fulllist = [];
		foreach ($controllerlist as $controller):
			$handle = fopen('../controllers/' . $controller, "r");
			if ($handle) {
				while (($line = fgets($handle)) !== false) {
					if (preg_match('/public function action(.*?)\(/', $line, $display)):
						if (strlen($display[1]) > 2):
							$fulllist[substr($controller, 0, -4)][] = strtolower($display[1]);
						endif;
					endif;
				}
			}
			fclose($handle);
		endforeach;
		print_r($fulllist);exit;
		return $fulllist;
	}

	public static function getmenus($user){
		$menu = new Menu();
		$user = User::find()->where(['id'=> $user])->one();
		$menus = Menu::find()->where('statut<>0')->all();
		$droits = [];
		if($user->profile->droit){    
			$droit = json_decode($user->profile->droit);
			foreach ($droit as $key => $value) {
				$droits[$key] = $value;
			}
		}

		$_menus = [];
		foreach ($droits as $key => $droit) {
			if(is_numeric($key)){
        		//$menu = Menu::find()->where(['id'=>$key])->one();

        		//$sousMenus = sousMenu::find()->where('id ='.$menu->id.' and statut<>0')->all();
				$sousmenu = explode(',', $droit);
				$_menus[$key] = $sousmenu;
			}
		}

		$menus = [];

		foreach ($_menus as $key => $_sousmenus) {
			$menu = Menu::find()->where(['id'=>$key])->one();
			foreach ($_sousmenus as $key => $_sousmenu) {
				$sousMenus = sousMenu::find()->where(['id' => $_sousmenu])->one();
				if($sousMenus){	
					$menus[$menu->libelle.'*'.$menu->lien][] = $sousMenus->libelle.'*'.$sousMenus->lien.'*'.$sousMenus->visible;
				}else{
					$menus[$menu->libelle.'*'.$menu->lien][] = $menu->libelle.'*'.$menu->lien;
				}
			}
		}
		//print_r($menus);exit;
		return $menus;
	}
}
