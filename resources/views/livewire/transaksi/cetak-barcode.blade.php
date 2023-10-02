<html>
    <head>
    <style>
        @page {
            size: 7.5cm 23.5cm;  potrait; 
            margin:0 10px; 
            font-size:10px;
        }
        @media print {
            @page {
                size: 7.5cm 23.5cm;  potrait; 
                margin:0 10px; 
                font-size:10px;
            }
        }
    </style>
    </head>
<body style="padding-top:20px;padding-left:20px">    
    <p>{{$product->keterangan}}</p>
    {!! DNS1D::getBarcodeHTML($no, 'EAN13')!!}
    <b style="letter-spacing: 10px;">{{$no}}</b>
    <h2>{{format_idr($product->harga_jual)}}</h2>
</body>
</html>