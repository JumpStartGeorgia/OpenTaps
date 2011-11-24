
use strict;
use PDF::FromHTML;

my $pdf = PDF::FromHTML->new(encoding => 'utf-8');
$pdf->load_file('the_html.html');
$pdf->convert(
        # With PDF::API2, font names such as 'traditional' also works
        Font        => 'font.ttf',
        LineHeight  => 10,
        Landscape   => 1,
    );
    
    $pdf->write_file('target.pdf');
