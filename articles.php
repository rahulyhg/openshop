<?php
	session_start();
	$site_name="openshop";
	$icon ="/asset/icon.png";
	$css=array("https://use.fontawesome.com/releases/v5.0.6/css/all.css",
	"https://unpkg.com/purecss@1.0.0/build/pure-min.css",
	"https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css","/asset/style.css",);
	$designer=$author="gamgine";
	$img = "/asset/banniere.jpg";
	$title="articles ".((isset($_GET['cat']))?'category '.htmlentities($_GET['cat']):'').(isset($_GET['p'])?' page '.(intval(htmlentities($_GET['p']))*10)-10:'');
	$desc="cat + articles page";
	
	include("asset/bdd.php");
	$cat=array();
	$reponse = $bdd->prepare('SELECT `name` FROM `category`');
	$reponse->execute();
	while ($donnees = $reponse->fetch()){array_push($cat,$donnees['name']);}
	
	$page=(isset($_GET['p']))?(intval(htmlentities($_GET['p']))*10)-10:1;
	if(isset($_GET['cat']))
	{
	$reponse = $bdd->prepare('SELECT `articles`.*,`img`.url FROM `articles`,category,`img` WHERE `img`.`id`= ifnull( `articles`.`img` , 0 ) and `articles`.`id`>0 and `articles`.`cid` = `category`.`id` and `category`.`name` = :cat order by `id` LIMIT :p,10');
	$reponse->bindValue(':cat',htmlentities($_GET['cat']),PDO::PARAM_STR);
	$reponse->bindValue(':p',$page,PDO::PARAM_INT);
	}
	else
	{
	$reponse = $bdd->prepare('SELECT `articles`.*,`img`.url FROM `articles`,`img` WHERE `img`.`id`= ifnull( `articles`.`img` , 0 ) and `articles`.`id`>0 order by `id` LIMIT :p,10');
	$reponse->bindValue(':p',$page,PDO::PARAM_INT);
	}
	$reponse->execute();
	$articles=array();
	while ($donnees = $reponse->fetch())
	{array_push($articles, array('name'=>htmlentities($donnees['name']),/*'sdesc'=>"ttt"*/'sdesc'=>nl2br(htmlentities(substr($donnees['txt'],0,124))),'prix'=>$donnees['prix'],'img'=>"/articlesimg/".$donnees['url'],'url'=>"/article-".htmlentities(str_replace(' ', '-',$donnees['name']))."-".$donnees['id'].".html",'action'=>"/action/buy.html/id=".$donnees['id']) );}
	$reponse->closeCursor();
	
	if(isset($_GET['cat']))
	{
	$reponse = $bdd->prepare('select count(articles.id) as n FROM articles,category WHERE articles.cid=category.id and category.name = :cat;');
	$reponse->bindValue(':cat',htmlentities($_GET['cat']),PDO::PARAM_STR);
	}
	else{$reponse = $bdd->prepare('SELECT count(articles.id) as n FROM `articles`;');}
	$reponse->execute();
	$donnees = $reponse->fetch();
	$pages=($donnees['n']/10)+1;
	$reponse->closeCursor();

	include("view/articles.php");