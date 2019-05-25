
<?php foreach ($this->results as $result) { ?>

	<ul>

		<?php foreach ($result as $k => $v) { ?>
		
			<li>
				<?php echo "$k: $v"; ?>
			</li>
		
		<?php } ?>

	</ul>
	
	<hr />

<?php } ?>