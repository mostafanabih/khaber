<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="https://cdn.moyasar.com/mpf/1.12.0/moyasar.css" />

  <!-- Moyasar Scripts -->
  <script src="https://cdn.moyasar.com/mpf/1.12.0/moyasar.js"></script>

</head>
    <div class="mysr-form"></div>
<script>
  Moyasar.init({
    element: '.mysr-form',
    // Amount in the smallest currency unit.
    // For example:
    // 10 SAR = 10 * 100 Halalas
    // 10 KWD = 10 * 1000 Fils
    // 10 JPY = 10 JPY (Japanese Yen does not have fractions)
    amount: {{$total_price}}*100,
    currency: 'SAR',
    description: ' Order',
   publishable_api_key:'{{env('MOYASAR_KEY')}}',

    callback_url:'{{env('APP_URL')}}/patient/paymongo-payment-success' ,
    methods: ['creditcard'],

  })
</script>
