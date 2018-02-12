<?php $url="/articles.php"; ?>
<!doctype html>
<html lang="<?=$lang="en"?>">
<?php include('asset/head.php'); ?>
	<body>
<?php include('header.php'); ?>
		<main class="pure-g">
			<section class="pure-u-20-24 pure-g " id="articles">
<?php 
foreach($articles as $article)
{
echo '				<article class="pure-u-sm-1-1 pure-u-md-10-24 pure-u-lg-1-4 pure-u-xl-4-24 dc">
					<a href="'.$article['url'].'" class="dc"></a><img src='.$article['img'].' alt="ar img" width="100%">
					<h2>'.$article['name'].'</h2><p>'.$article['sdesc'].'</p>
					<p class="link"><a href="'.$article['url'].'">see the offer</a> <a href="#">buy now</a></p>
				</article>';
}?>
			</section>
		</main>
<?php include('footer.html'); ?>	
	</body>
</html>