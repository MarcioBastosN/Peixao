<div class="form-group">
    <div class="btn-group" id="btn-imprime">
        <a class="btn btn-primary form-control dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-bars"></i>Download Tabela</a>
        <ul class="dropdown-menu">
            <li><a href="#" target="_blank" onclick="$('#tabela').tableExport({type:'pdf',pdfFontSize:'12',escape:'false'});"><i class="fa fa-file-pdf-o fa-fw"></i> PDF</a></li>
            <li><a href="#" target="_blank" onclick="$('#tabela').tableExport({type:'png',escape:'false'});"><i class="fa fa-file-image-o fa-fw"></i> PNG</a></li>
            <li class="divider"></li>
            <li><a href="#" id="Imprimir"><i class="fa fa-print"></i>Imprimir</a></li>
        </ul>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#btn-imprime li a").on("click", function(event){
            event.preventDefault();
        });
        $("#Imprimir").on("click",function(){
            window.print();
        });
        $("#btn-imprime2 li a").on("click", function(event){
            event.preventDefault();
        });
    });
</script>