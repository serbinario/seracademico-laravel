<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Biblioteca</title>
    <style type="text/css">
        table tbody th, table tbody td {
            padding: 2px 2px;
            font-size: 12px;
        }

        table { page-break-inside:auto }
        tr { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
    </style>
</head>

<body>
<div class="row">
    <table width="100%">
        <tr>
            <td width="20%">
                <img alt="image" width="100%" src="{{ asset('/img/logo-alpha.png')}}"/>
            </td>
            <td width="55%"><br>
                <h1 style="text-align: center;color: #082652; ">Lista de Livros por Curso</h1>
            </td>
            <td width="15%">
                <img alt="image" width="100%" src="{{ asset('/img/seracad.png')}}"/>
            </td>
        </tr>
    </table>
</div>
<hr>
<div class="row">

        <table id="report_biblioteca" width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;" >
            <thead>
            <tr style="background-color: #2F5286; color: white;">
                <th>Referência</th>
                <th>CDD</th>
                <th>CUTTER</th>
                <th>Quantidade de exemplares</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cursos as $curso)
                <tr style="padding: 8px; background-color: #bbcde7">
                    <td colspan="4">CURSO - {{$curso->nome}}</td>
                </tr>
                @foreach($curso->livros as $livro)
                    <tr>
                        <td>

                            <?php $count = 0; ?>
                            @if(count($livro->autores) > 0)
                                @if($livro->etial_autor == '1')
                                    @if($livro->autores[0]->tipo_reponsavel_id == '1' || $livro->autores[0]->tipo_reponsavel_id == "")
                                        <span style="text-transform: uppercase">{{$livro->autores[0]->sobrenome}}</span>,
                                        {{$livro->autores[0]->nome}} et al.
                                    @else
                                        <span style="text-transform: uppercase"><?php echo ucwords(mb_strtolower($livro->autores[0]->nome)) ?></span><?php if (strrchr($livro->autores[0]->nome, ".") == ".") { echo "";} else {echo ".";} ?>
                                    @endif
                                @else
                                    @foreach($livro->autores as $chave => $autor)
                                        <?php $count++ ?>
                                        @if($autor->tipo_reponsavel_id == '1' || $autor->tipo_reponsavel_id == "")
                                            <span style="text-transform: uppercase">{{$autor->sobrenome}}</span>,
                                            <?php echo $autor->nome; ?>@if(count($livro->autores) == $count )<?php if (strrchr($autor->nome, ".") == ".") { echo "";} else {echo ".";} ?> @else;@endif
                                        @else
                                            <?php echo $autor->nome; ?>@if(count($livro->autores) == $count )<?php if (strrchr($autor->nome, ".") == ".") { echo "";} else {echo ".";} ?> @else;@endif
                                        @endif
                                    @endforeach
                                @endif
                            @elseif(count($livro->outros) > 0)
                                @if($livro->etial_outros == '1')
                                    @if($livro->outros[0]->tipo_reponsavel_id == '1' || $livro->outros[0]->tipo_reponsavel_id == "")
                                        <span style="text-transform: uppercase">{{$livro->outros[0]->sobrenome}}</span>,
                                        <?php echo $livro->outros[0]->nome ?>
                                        <?php if($livro->outros[0]->tipo_autor_id == 1) {echo ' (Org.) ';} ?>
                                        <?php if($livro->outros[0]->tipo_autor_id == 2) {echo ' (Coord.) ';} ?>
                                        <?php if($livro->outros[0]->tipo_autor_id == 3) {echo ' (Trad.) ';} ?>
                                        <?php if($livro->outros[0]->tipo_autor_id == 4) {echo ' (Edit.) ';} ?>
                                        <?php if($livro->outros[0]->tipo_autor_id == 5) {echo ' (Colab.) ';} ?>et al.
                                    @else
                                        <span style="text-transform: uppercase"><?php echo ucwords(mb_strtolower($livro->outros[0]->nome)) ?></span><?php if (strrchr($livro->outros[0]->nome, ".") == ".") { echo "";} else {echo ".";} ?>
                                    @endif
                                @else
                                    @foreach($livro->outros as $chave => $autor)
                                        <?php $count++; ?>
                                        @if($autor->tipo_reponsavel_id == '1' || $autor->tipo_reponsavel_id == "")
                                            @if($chave == 0 && $autor->para_referencia1 == '1')
                                                @if($autor->exibir_tipo1 == '1')
                                                    <span style="text-transform: uppercase">{{$autor->sobrenome}}</span>,
                                                    <?php echo $autor->nome; ?>
                                                    <?php if($autor->tipo_autor_id == 1) {echo ' (Org.)';} ?>
                                                    <?php if($autor->tipo_autor_id == 2) {echo ' (Coord.)';} ?>
                                                    <?php if($autor->tipo_autor_id == 3) {echo ' (Trad.)';} ?>
                                                    <?php if($autor->tipo_autor_id == 4) {echo ' (Edit.)';} ?>
                                                    <?php if($autor->tipo_autor_id == 5) {echo ' (Colab.)';} ?>@if(count($livro->outros) == $count ).@else;@endif
                                                @else
                                                    <span style="text-transform: uppercase">{{$autor->sobrenome}}</span>,
                                                    <?php echo $autor->nome; ?>@if(count($livro->outros) == $count ).@else;@endif
                                                @endif
                                            @elseif ($chave == 1 && $autor->para_referencia2 == '1')
                                                @if($autor->exibir_tipo2 == '1')
                                                    <span style="text-transform: uppercase">{{$autor->sobrenome}}</span>,
                                                    <?php echo $autor->nome; ?>
                                                    <?php if($autor->tipo_autor_id == 1) {echo ' (Org.)';} ?>
                                                    <?php if($autor->tipo_autor_id == 2) {echo ' (Coord.)';} ?>
                                                    <?php if($autor->tipo_autor_id == 3) {echo ' (Trad.)';} ?>
                                                    <?php if($autor->tipo_autor_id == 4) {echo ' (Edit.)';} ?>
                                                    <?php if($autor->tipo_autor_id == 5) {echo ' (Colab.)';} ?>@if(count($livro->outros) == $count ).@else;@endif
                                                @else
                                                    <span style="text-transform: uppercase">{{$autor->sobrenome}}</span>,
                                                    <?php echo $autor->nome; ?>@if(count($livro->outros) == $count ).@else;@endif
                                                @endif
                                            @elseif ($chave == 2 && $autor->para_referencia3 == '1')
                                                @if($autor->exibir_tipo3 == '1')
                                                    <span style="text-transform: uppercase">{{$autor->sobrenome}}</span>,
                                                    <?php echo $autor->nome; ?>
                                                        <?php if($autor->tipo_autor_id == 1) {echo ' (Org.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 2) {echo ' (Coord.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 3) {echo ' (Trad.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 4) {echo ' (Edit.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 5) {echo ' (Colab.)';} ?>@if(count($livro->outros) == $count ).@else;@endif
                                                @else
                                                    <span style="text-transform: uppercase">{{$autor->sobrenome}}</span>,
                                                    <?php echo $autor->nome; ?>@if(count($livro->outros) == $count ).@else;@endif
                                                @endif
                                            @endif
                                        @else
                                            @if($chave == 0 && $autor->para_referencia1 == '1')
                                                @if($autor->exibir_tipo1 == '1')
                                                        <?php echo $autor->nome; ?>
                                                        <?php if($autor->tipo_autor_id == 1) {echo ' (Org.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 2) {echo ' (Coord.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 3) {echo ' (Trad.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 4) {echo ' (Edit.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 5) {echo ' (Colab.)';} ?>@if(count($livro->outros) == $count ).@else;@endif
                                                @else
                                                    <span style="text-transform: uppercase">{{$autor->sobrenome}}</span>,
                                                    <?php echo $autor->nome; ?>@if(count($livro->outros) == $count ).@else;@endif
                                                @endif
                                            @elseif ($chave == 1 && $autor->para_referencia2 == '1')
                                                @if($autor->exibir_tipo2 == '1')
                                                        <?php echo $autor->nome; ?>
                                                        <?php if($autor->tipo_autor_id == 1) {echo ' (Org.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 2) {echo ' (Coord.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 3) {echo ' (Trad.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 4) {echo ' (Edit.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 5) {echo ' (Colab.)';} ?>@if(count($livro->outros) == $count ).@else;@endif
                                                @else
                                                    <span style="text-transform: uppercase">{{$autor->sobrenome}}</span>,
                                                    <?php echo $autor->nome; ?>@if(count($livro->outros) == $count ).@else;@endif
                                                @endif
                                            @elseif ($chave == 2 && $autor->para_referencia3 == '1')
                                                @if($autor->exibir_tipo3 == '1')
                                                        <?php echo $autor->nome; ?>
                                                        <?php if($autor->tipo_autor_id == 1) {echo ' (Org.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 2) {echo ' (Coord.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 3) {echo ' (Trad.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 4) {echo ' (Edit.)';} ?>
                                                        <?php if($autor->tipo_autor_id == 5) {echo ' (Colab.)';} ?>@if(count($livro->outros) == $count ).@else;@endif
                                                @else
                                                    <span style="text-transform: uppercase">{{$autor->sobrenome}}</span>,
                                                    <?php echo $autor->nome; ?>@if(count($livro->outros) == $count ).@else;@endif
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                            @if(count($livro->autores) <= 0 && count($livro->outros) <= 0)

                                <?php
                                $array = explode(' ', $livro->titulo);
                                $paravra = "";

                                if (strlen($array[0]) <= 1) {
                                    $paravra .= ucwords(mb_strtoupper($array[0] . " " . $array[1])) . " ";
                                    for ($i = 2; $i < count($array); $i++) {
                                        $paravra .= mb_strtolower($array[$i]);
                                        if ($i >= count($array)) {
                                            $paravra .= "";
                                        } else {
                                            $paravra .= " ";
                                        }
                                    };
                                } else {
                                    $paravra .= ucwords(mb_strtoupper($array[0])) . " ";
                                    for ($i = 1; $i < count($array); $i++) {
                                        $paravra .= mb_strtolower($array[$i]);
                                        if ($i >= count($array)) {
                                            $paravra .= "";
                                        } else {
                                            $paravra .= " ";
                                        }
                                    };
                                }

                                ?>

                                @if($livro->tipo_periodico == '1')
                                    <b> {{$paravra}} @if($livro->subtitulo)<?php echo ': '. mb_strtolower($livro->subtitulo) ?>.@else.@endif  </b>
                                @elseif($livro->tipo_periodico == '2')
                                    {{mb_strtoupper($paravra)}} @if($livro->subtitulo)<?php echo ': '. mb_strtoupper($livro->subtitulo) ?>.@else.@endif
                                @endif

                            @else
                                <b><?php echo $livro->titulo ?></b>@if($livro->subtitulo)<?php echo ': '. mb_strtolower($livro->subtitulo) ?>.@else.@endif
                            @endif
                            @if($livro->edicao && $livro->tipo_periodico == '1')
                                {{$livro->edicao}}. ed.
                                @if($livro->ampliada && !$livro->revisada && !$livro->atualizada) ampl.
                                @elseif($livro->revisada && !$livro->ampliada && !$livro->atualizada) rev.
                                @elseif($livro->atualizada && !$livro->ampliada && !$livro->revisada) atual.
                                @elseif($livro->ampliada && $livro->revisada) ampl. e rev.
                                @elseif($livro->ampliada && $livro->atualizada) ampl. e atual.
                                @elseif($livro->revisada && $livro->atualizada) rev. e atual.
                                @elseif($livro->revisada && $livro->atualizada && $livro->ampliada) ampl. e rev. e atual.
                                @endif
                            @endif
                            @if($livro->tipo_periodico == '2')
                                v. {{$livro->vol_periodico}}, n. {{$livro->num_periodico}},
                            @endif
                            @if($livro->local)<?php echo ucwords(mb_strtolower($livro->local)) ?>: @endif
                            @if($livro->editora)<?php echo $livro->editora ?>, @endif
                            @if($livro->ano){{$livro->ano}}. @endif @if($livro->numero_pag){{$livro->numero_pag}}p., @endif
                            @if($livro->tipo_periodico == '1')
                                @if($livro->ilustracoes_id == '1')il., @endif
                            @endif
                            @if($livro->tipo_periodico == '1')
                                @if($livro->isbn)ISBN {{$livro->isbn}}. @endif
                            @else
                                @if($livro->issn)ISSN {{$livro->issn}}. @endif
                            @endif

                        </td>
                        <td>
                            {{$livro->cdd}}
                        </td>
                        <td>
                            {{$livro->cutter}}
                        </td>
                        <td>
                            {{$livro->qtdExemplares}}
                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>

</div>
</body>
</html>