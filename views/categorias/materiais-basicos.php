<?php 
	namespace Models;
	$crud=new ModelCrud();

?>


<header>
	<nav>
		<ul>
			<li>    <a href="<?php echo DIRPAGE.'myaccount/purchase'; ?>">Meu Carrinho</a> </li>
		</ul>
	</nav>

</header>





<?php require_once 'include/select-categorias.php';?>


<h2>Materiais Básicos</h2>

       
<?php 
			
				
	$BFetch=$crud->selectDB("*", "produtos", "WHERE categoria=?",
					  array('materiais_basicos'));
		while($ads=$BFetch->fetch(\PDO::FETCH_ASSOC))
		{?>


		<P>
			<?php echo $ads['id']; ?>
			<?php echo $ads['nome'];?></P>
			Quantidade:<input type="number" name="" id="">
			<button type="text">Adiconar Ao Orçamento</button>

		<hr>

		<?php 	
		}	
		?>


