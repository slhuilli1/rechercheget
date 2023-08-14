<?php

	defined('_JEXEC') or die('Access deny');

	class plgContentRechercheGET extends JPlugin //Concatener à "plg" le nom du groupe (ici Content) puis le nom du plugin ( que l'on trouve ds le XML ligne extension) : plg<Plugin Group><Plugin name>
	{
		function onContentPrepare($content, $article, $params, $limit){	
			$doc = JFactory::getDocument();
			$doc->addStyleSheet('plugins/content/rechercheget/style.css');
			$re = '/\{recherche_get\}/mi';
			$sql = "SELECT #__content.id, #__categories.title, #__content.title,  #__content.introtext
					FROM #__content, #__categories 	
					WHERE `introtext` LIKE '%".$_GET["chaine_recherchee"]."%' 
					AND #__categories.id = #__content.catid
					ORDER BY #__content.id DESC";
					
					echo $sql;
			$db = JFactory::getDBO();
			$db->setQuery($sql);
			$row = $db->loadObjectList();
			
			$ch = '<div class="mes-resultats-de-recherches-get">';
			$ch .= '<div class="libelle">Liste des articles dans lesquel le terme <span class="terme">'.$_GET["chaine_recherchee"].'</span> a été trouvé :</div>';
			
			foreach($row as $z)
			{
				$url = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."?option=com_content&view=article&id=".$z->id;
				$ch .= '<div class="un-resultat"><div class="id">'.$z->id.'</div><div class="title"><a href="'.$url.'">'.$z->title."</a></div></div>";
			}
			$ch .= '</div>';
			$article->text = str_replace('{recherche_get}', $ch , $article->text);
		}	
	}


	

