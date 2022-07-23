<table border="1">
    <tr>
        <td>ID</td>
        <td>FECHA PEDIDO</td>
        <td>CLIENTE</td>
        <td>ESTADO</td>
    </tr>

    @foreach ($pedidos as $p)
    <tr>
        <td>{{ $p->id }}</td>
        <td>{{ $p->fecha_pedido }}</td>
        <td>{{ $p->cliente->nombre_completo }}</td>
        <td>{{ ($p->estado == 1)?'PENDIENTE':'COMPLETADO' }}</td>
    </tr>
    @endforeach

</table>