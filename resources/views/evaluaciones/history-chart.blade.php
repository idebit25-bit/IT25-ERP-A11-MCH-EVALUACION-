@php
    $minimum = min(0, (float) $series->min('total_score'));
    $maximum = max(1, (float) $series->max('total_score'));
    $coordinates = $series->map(fn ($item, $index) => [
        'x' => 65 + $index * (650 / max(1, $series->count() - 1)),
        'y' => 185 - (((float) $item->total_score - $minimum) / ($maximum - $minimum)) * 150,
    ]);
@endphp
<svg viewBox="0 0 780 240" class="w-100" style="max-height: 300px" role="img" aria-labelledby="history-chart-title history-chart-description">
    <title id="history-chart-title">Resultados publicados por periodo</title>
    <desc id="history-chart-description">Cada punto representa una evaluación. Los valores exactos y periodos se muestran en la tabla siguiente.</desc>
    @foreach([0, 0.5, 1] as $fraction)
        <line x1="65" y1="{{ 185 - 150 * $fraction }}" x2="735" y2="{{ 185 - 150 * $fraction }}" stroke="#dee2e6" />
        <text x="52" y="{{ 190 - 150 * $fraction }}" text-anchor="end" fill="#555" font-size="13">{{ number_format($minimum + ($maximum - $minimum) * $fraction, 2) }}</text>
    @endforeach
    <polyline points="{{ $coordinates->map(fn ($point) => $point['x'].','.$point['y'])->implode(' ') }}" fill="none" stroke="#245cf4" stroke-width="3" />
    @foreach($series as $index => $item)
        <circle cx="{{ $coordinates[$index]['x'] }}" cy="{{ $coordinates[$index]['y'] }}" r="5" fill="#245cf4"><title>{{ $item->period?->name }}: {{ number_format($item->total_score, 2) }}</title></circle>
        <text x="{{ $coordinates[$index]['x'] }}" y="212" text-anchor="middle" fill="#555" font-size="13">#{{ $item->id }}</text>
    @endforeach
</svg>
<div class="table-responsive"><table class="table table-sm">
    <caption>Resultados utilizados en la gráfica, del periodo más antiguo al más reciente.</caption>
    <thead><tr><th>Evaluación</th><th>Periodo</th><th>Resultado</th></tr></thead>
    <tbody>@foreach($series as $item)<tr><td>#{{ $item->id }}</td><td>{{ $item->period?->name }}</td><td>{{ number_format($item->total_score, 2) }}</td></tr>@endforeach</tbody>
</table></div>
