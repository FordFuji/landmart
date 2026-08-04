<?php
class ControllerTestTest extends Controller {
	
    public function index() {
?>
        <script type="text/javascript" src="https://cdn.omise.co/omise.js"></script>

        <script>
        Omise.setPublicKey('pkey_test_5rpwigssywmnsk618oq');

        Omise.createSource('installment_bbl', {
            "amount": 400000,
            "currency": "THB",
            "installment_term": 4,
            "zero_interest_installments": false,

        }, function(statusCode, response) {
            console.log(statusCode)
            console.log(response)
        });
        </script>
<?php
	}
}