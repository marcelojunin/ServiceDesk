<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Manter CD</title>

        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="../../../bootstrap/css/cd.css" rel="stylesheet" type="text/css"/>
        
        <link href="../../../bootstrap/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
        
        <script src="../../../bootstrap/js/jquery.js" type="text/javascript"></script>
        <script src="../../../bootstrap/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="../../../bootstrap/js/jquery.form.js" type="text/javascript"></script>
        
        <script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../../../bootstrap/js/jquery.forms.js" type="text/javascript"></script>
        <script src="../../../bootstrap/js/bootbox.min.js" type="text/javascript"></script>
        
        <script type="text/javascript">
        
        $(document).ready(function(){
				$('#tabela1').dataTable();
                                
                                $(document).ready(function(){
                                     $('.dropdown-toggle').dropdown();
                        });
		});
        
        
        /*
    	 * Função que carrega após o DOM estiver carregado.
    	 * Como estou usando o ajaxForm no formulário, é aqui que eu o configuro.
    	 * Basicamente somente digo qual função será chamada quando os dados forem postados com sucesso.
    	 * Se o retorno for igual a 1, então somente recarrego a janela.
    	 */
    	$(function(){
    		$('#formulario_cd').ajaxForm({
    			success: function(data) {
    				if (data == 1 || data == 11) {
    					
    					//Algo esta acontecendo no controller que está trazendo 11 no lugar de 1.
    					//Faço esse if com || pq preciso que atualize a pagina.
    					//se for sucesso, simplesmente recarrego a página. Aqui você pode usar sua imaginação.
    					document.location.href = document.location.href;
				    	
    				}else{
                                    alert(data);
                                }
    			}
    		});
    	});
    
    	//Aqui eu seto uma variável javascript com o base_url do CodeIgniter, para usar nas funções do post.
    	var base_url = "<?= base_url() ?>";
    	
	    /*
	     *	Esta função serve para preencher os campos do cliente na janela flutuante
	     * usando jSon.  
	     */
    	function carregaDadosCdJSon(idcd){
    		$.post(base_url+'/index.php/cd/cd_controller/dados_cd', {
    			idcd: idcd
    		}, function (data){
    			$('#nomecd').val(data.nomecd);
    			$('#gravadora').val(data.gravadora);
    			$('#idcd').val(data.idcd);//aqui eu seto a o input hidden com o id do cliente, para que a edição funcione. Em cada tela aberta, eu seto o id do cliente. 
    		}, 'json');
    	}
    
    	function janelaNovoCd(idcd){
    		
    		//antes de abrir a janela, preciso carregar os dados do cliente e preencher os campos dentro do modal
    		carregaDadosCdJSon(idcd);
                //alert(idcd);
    		
	    	$('#modalEditarCliente').modal('show');
    	}
        
        function limparCampo(){
            $("#idcd").val(''); 
            $("#nomecd").val(''); 
            $("#gravadora").val(''); 
        }
        
    	function janelaCadastroCd(){
            // na função limparCampo() eu apago os valores que estão no modal
            // devido ter aberto o modal anteriormente, fica salvo os valores.
                limparCampo();
            
    		$('#modalEditarCliente').modal('show');
    	}
        
        function confirma(){
        if (!confirm("Confirma a exclusão?"))
          return false;
        return true;
        }
        
        
        </script>
        
	
</head>
<body>

<div id="container">
	<h1>Manter CD</h1>
        <div id="body">
        <div id="bts_manter_cd">
            <div class="btn-group btn-group-justified" style="margin-left: 22%;">
                <button type="button" class="glyphicon glyphicon-plus"  onclick="janelaCadastroCd()"></button>
                <button type="button" class="glyphicon glyphicon-home"></button>
                <button type="button" class="glyphicon glyphicon-off"></button>
            </div>
        </div>
           <table cellspacing="0"  cellpadding="0" border="0" class="display" id="tabela1">
                <thead>
                    <tr>
                    <th>Código do CD</th>
                    <th>Nome do CD</th>
                    <th>Gravadora</th>
                    <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    
                <?php foreach ($consulta -> result() as $linha): ?> 
                    
                <tr>
                    <td style="text-align: center;"><?php echo $linha->idcd ?></td>
                    <td style="text-align: center;"><?php echo $linha->nomecd ?></td>
                    <td style="text-align: center;"><?php echo $linha->gravadora ?></td>
                    <td style="text-align: center;"><a href="javascript:;" onclick="janelaNovoCd(<?= $linha->idcd ?>)">Editar | <?php echo anchor("cd/cd_controller/excluir_cd/$linha->idcd", "Excluir", array("onclick" => "return confirma()")) ?></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            
	</div>
        

        <div class="modal fade bs-example-modal-lg" id="modalEditarCliente" >
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
	        <h4 class="modal-title">Novo CD</h4>
	      </div>
	      <div class="modal-body">
	      	
			<form role="form" method="post" action="<?= base_url('index.php/cd/cd_controller/salvar_cd')?>" id="formulario_cd">
			  <div class="form-group">
			    <label for="nome">Nome do CD</label>
			    <input type="text" class="form-control" id="nomecd"  name='nomecd'>
			  </div>
			  <div class="form-group">
			    <label for="email">Gravadora</label>
			    <input type="email" class="form-control" id="gravadora" name='gravadora'>
			  </div>
			  <input type="hidden" name="idcd" id="idcd" value="" />
			</form>	    
			    
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal" >Fechar</button>
	       
               <button type="button" class="btn btn-primary" onclick="$('#formulario_cd').submit()">Salvar</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->  
        
        
	<p class="footer"><a href="javascript: history.back()">Voltar</a> <strong>{elapsed_time}</strong> seconds</p>
</div>
    
</body>
</html>
