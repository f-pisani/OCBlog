<?php
use Lib\Config;
use Models\User;

include 'navbar.inc.php';
?>

<div id="blog">
	<?php
	foreach($articles_list as $article)
	{
	?>

	<div id="post">
		<h1 class="title">&nbsp;&nbsp;&nbsp;<?= htmlentities($article['title'], ENT_HTML5 | ENT_QUOTES ) ?></h1>
		<div class="content"><?= $article['content'] ?></div>
		<div class="footer">
			<div class="metadata"><span class="author">Par <b><?= $article['user_displayName'] ?></b> publié le <?= date('d/m/Y \à H:i', $article['created_at']) ?></span>
			<?php
			if($article['updated_at'] != $article['created_at'])
				echo "<span class=\"update\">Mis à jour le ". date('d/m/Y \à H:i', $article['updated_at']) ."</span>";
			?>
			</div>
			<div class="nextprev">
				<?php
				if($article['next'] != null)
					echo "<span>Suivant :
							<a data-nav=\"next\" href=\"".Config::get('BASE_URL')."articles/".$article['next']['id']."\">
							".htmlentities($article['next']['title'], ENT_HTML5 | ENT_QUOTES )."</a></span>";

				echo "<span>Actuel : ". htmlentities($article['title'], ENT_HTML5 | ENT_QUOTES ) ."</span>";

				if($article['prev'] != null)
					echo "<span>Précédent :
					      	<a data-nav=\"prev\" href=\"".Config::get('BASE_URL')."articles/".$article['prev']['id']."\">
							".htmlentities($article['prev']['title'], ENT_HTML5 | ENT_QUOTES )."</a></span>";
				?>
			</div>
		</div>
	</div>

	<div id="comments">
		<h1 class="title">&nbsp;&nbsp;&nbsp;Commentaire(s)</h1>
		<p><?= count($article['comments']) ?> commentaire(s) pour cet article. Laissez nous votre ressenti !</p>
		<?php
		if(User::isLogged())
		{
			include 'admin/msg.inc.php';
		?>
			<form id="form-comment" class="form" action="<?= Config::get('BASE_URL')."articles/".$article['id'] ?>#comments" method="post">
				<div class="form-row">
					<label class="label" for="comment">Commentaire :</label>
					<textarea class="input" id="comment" name="comment" placeholder="Très bon chapitre, j'attends la suite avec impatience !"></textarea>
				</div>

				<button type="submit" class="btn">Envoyer mon commentaire</button>
			</form>
		<?php
		}
		else
			echo "<div class=\"msg-error\"><p>Vous devez être connecté pour laisser un commentaire.</p></div>";

		foreach($article['comments'] as $comment)
		{
		?>
		<div class="comment">
			<span class="author">Par <b><?= $comment['nickname'] ?></b> le <?= date('d/m/Y à H:i:s', $comment['created_at']) ?></span>
			<div class="content"><?= $comment['content'] ?></div>
			<?php
			if(User::isLogged() && $comment['user_id'] != User::id() && !in_array($comment['id'], $user_reports))
			{
			?>
			<div class="footer">
				<a class="link-flat" href="<?= Config::get('BASE_URL')."report/".$article['id']."/".$comment['id'] ?>"><i class="fas fa-exclamation-triangle"></i> Signaler</a>
			</div>
			<?php
			}
			?>
		</div>
		<?php
		}
		?>
		<a id="showMoreComments" class="link-btn" href="javascript:void(0)" onClick="showMoreComments()">Voir plus de commentaires...</a>
	</div>
	<?php
	}
	?>
</div>

<script>
	var showMoreComments_offset = 5; // Number of comments to show
	var currentComments_displayed = showMoreComments_offset;

	function showMoreComments()
	{
		console.log(currentComments_displayed+"/"+$("#comments .comment").length)
		currentComments_displayed += showMoreComments_offset;

		$("#comments .comment").each(function(i, item){
			if(i+1 <= currentComments_displayed)
			{
				$("#comments .comment:nth-of-type("+(i+1)+")").slideDown(500).css('display', 'block');
			}
		});

		if(currentComments_displayed >= $("#comments .comment").length)
			$("a#showMoreComments").hide(500).css('display', 'none');
		else
		{
			$('html, body').animate({
				 scrollTop: $("#comments .comment:nth-of-type("+currentComments_displayed+")").offset().top
			 }, 500);
		}
	}

	//
	$(window).bind("mousewheel", function() {
		$("html, body").stop(true, false);
	});

	$(document).ready(function(){
		$("#comments .comment").each(function(i, item){
			if(i+1 > currentComments_displayed)
			{
				$("#comments .comment:nth-of-type("+(i+1)+")").hide(500).css('display', 'none');
			}
		});

		if($("#comments .comment").length == 0 ||$("#comments .comment").length <= currentComments_displayed)
			$("a#showMoreComments").hide(500).css('display', 'none');
	});
</script>
<?php include 'footer.inc.php'; ?>
