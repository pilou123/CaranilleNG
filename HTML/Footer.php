</article>
		</section>

		<aside>
			<?php require($_SESSION['File_Root'] ."/HTML/Right.php"); ?>
		</aside>

		<p>

		<footer>
			<a href="https://github.com/Caranille/Caranille">MMORPG crée avec Caranilleng</a><br />
			<?php
			$timeend=microtime(true);
			$time=$timeend-$timestart;
			$page_load_time = number_format($time, 3);
			echo "Execution time: $page_load_time seconds";
			?>
		</footer>

		</p>
	</body>
</html>
