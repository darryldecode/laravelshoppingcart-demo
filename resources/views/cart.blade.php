<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <!-- Styles -->
    <style>
        .cart {
            padding-bottom: 20px;
            padding-top: 20px;
        }
    </style>
</head>
<body>
<div class="row" id="app">
    <div class="container cart">
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>ADD ITEM</h2>
                        <p>(This is using custom database storage)</p>
                        <div class="form-group form-group-sm">
                            <label>ID</label>
                            <input v-model="item.id" class="form-control" placeholder="Id">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>Name</label>
                            <input v-model="item.name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>Price</label>
                            <input v-model="item.price" class="form-control" placeholder="Price">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>Qty</label>
                            <input v-model="item.qty" class="form-control" placeholder="Quantity">
                        </div>
                        <button v-on:click="addItem()" class="btn btn-primary">Add Item</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>ADD CONDITIONS</h2>
                        <div class="form-group form-group-sm">
                            <label>name*</label>
                            <input v-model="cartCondition.name" placeholder="Sale 5%" class="form-control" placeholder="Id">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>Type (Any string that defines the type of your condition)*</label>
                            <input v-model="cartCondition.type" placeholder="sale" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>Target*</label>
                            <select v-model="cartCondition.target" class="form-control">
                                <option v-for="target in options.target" :key="target.key" :value="target.key">
                                    @{{ target.label }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group form-group-sm">
                            <label>Value*</label>
                            <input v-model="cartCondition.value" placeholder="-12% or -10 or +10 etc" class="form-control" placeholder="Quantity">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <button v-on:click="addCartCondition()" class="btn btn-primary">Add Condition</button>
                    </div>
                    <div class="col-lg-6">
                        <button v-on:click="clearCartCondition()" class="btn btn-primary">Clear Conditions</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h2>CART</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in items">
                        <td>@{{ item.id }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.quantity }}</td>
                        <td>@{{ item.price }}</td>
                        <td>
                            <button v-on:click="removeItem(item.id)" class="btn btn-sm btn-danger">remove</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="table">
                    <tr>
                        <td>Items on Cart:</td>
                        <td>@{{itemCount}}</td>
                    </tr>
                    <tr>
                        <td>Total Qty:</td>
                        <td>@{{ details.total_quantity }}</td>
                    </tr>
                    <tr>
                        <td>Sub Total:</td>
                        <td>@{{ '$' + details.sub_total.toFixed(2) }} (@{{details.cart_sub_total_conditions_count}} conditions applied)</td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td>@{{ '$' + details.total.toFixed(2) }} (@{{details.cart_total_conditions_count}} conditions applied)</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row" id="wishlist">
    <div class="container cart">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>ADD WISHLIST ITEM</h2>
                        <p>(This is using default session storage)</p>
                        <div class="form-group form-group-sm">
                            <label>ID</label>
                            <input v-model="item.id" class="form-control" placeholder="Id">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>Name</label>
                            <input v-model="item.name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>Price</label>
                            <input v-model="item.price" class="form-control" placeholder="Price">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>Qty</label>
                            <input v-model="item.qty" class="form-control" placeholder="Quantity">
                        </div>
                        <button v-on:click="addItem()" class="btn btn-primary">Add Item</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h2>WISHLIST</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in items">
                        <td>@{{ item.id }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.quantity }}</td>
                        <td>@{{ item.price }}</td>
                        <td>
                            <button v-on:click="removeItem(item.id)" class="btn btn-sm btn-danger">remove</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="table">
                    <tr>
                        <td>Items on Cart:</td>
                        <td>@{{itemCount}}</td>
                    </tr>
                    <tr>
                        <td>Total Qty:</td>
                        <td>@{{ details.total_quantity }}</td>
                    </tr>
                    <tr>
                        <td>Sub Total:</td>
                        <td>@{{ '$' + details.sub_total.toFixed(2) }}</td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td>@{{ '$' + details.total.toFixed(2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="https://unpkg.com/vue"></script>
<script src="https://cdn.jsdelivr.net/vue.resource/1.3.1/vue-resource.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script>
    (function($) {

        var _token = '<?php echo csrf_token() ?>';

        $(document).ready(function() {

            var app = new Vue({
                el: '#app',
                data: {
                    details: {
                        sub_total: 0,
                        total: 0,
                        total_quantity: 0
                    },
                    itemCount: 0,
                    items: [],
                    item: {
                        id: '',
                        name: '',
                        price: 0.00,
                        qty: 1
                    },
                    cartCondition: {
                        name: '',
                        type: '',
                        target: '',
                        value: '',
                        attributes: {
                            description: 'Value Added Tax'
                        }
                    },

                    options: {
                        target: [
                            {label: 'Apply to SubTotal', key: 'subtotal'},
                            {label: 'Apply to Total', key: 'total'}
                        ]
                    }
                },
                mounted:function(){
                    this.loadItems();
                },
                methods: {
                    addItem: function() {

                        var _this = this;

                        this.$http.post('/cart',{
                            _token:_token,
                            id:_this.item.id,
                            name:_this.item.name,
                            price:_this.item.price,
                            qty:_this.item.qty
                        }).then(function(success) {
                            _this.loadItems();
                        }, function(error) {
                            console.log(error);
                        });
                    },
                    addCartCondition: function() {

                        var _this = this;

                        this.$http.post('/cart/conditions',{
                            _token:_token,
                            name:_this.cartCondition.name,
                            type:_this.cartCondition.type,
                            target:_this.cartCondition.target,
                            value:_this.cartCondition.value,
                        }).then(function(success) {
                            _this.loadItems();
                        }, function(error) {
                            console.log(error);
                        });
                    },
                    clearCartCondition: function() {

                        var _this = this;

                        this.$http.delete('/cart/conditions?_token=' + _token).then(function(success) {
                            _this.loadItems();
                        }, function(error) {
                            console.log(error);
                        });
                    },
                    removeItem: function(id) {

                        var _this = this;

                        this.$http.delete('/cart/'+id,{
                            params: {
                                _token:_token
                            }
                        }).then(function(success) {
                            _this.loadItems();
                        }, function(error) {
                            console.log(error);
                        });
                    },
                    loadItems: function() {

                        var _this = this;

                        this.$http.get('/cart',{
                            params: {
                                limit:10
                            }
                        }).then(function(success) {
                            _this.items = success.body.data;
                            _this.itemCount = success.body.data.length;
                            _this.loadCartDetails();
                        }, function(error) {
                            console.log(error);
                        });
                    },
                    loadCartDetails: function() {

                        var _this = this;

                        this.$http.get('/cart/details').then(function(success) {
                            _this.details = success.body.data;
                        }, function(error) {
                            console.log(error);
                        });
                    }
                }
            });

            var wishlist = new Vue({
                el: '#wishlist',
                data: {
                    details: {
                        sub_total: 0,
                        total: 0,
                        total_quantity: 0
                    },
                    itemCount: 0,
                    items: [],
                    item: {
                        id: '',
                        name: '',
                        price: 0.00,
                        qty: 1
                    }
                },
                mounted:function(){
                    this.loadItems();
                },
                methods: {
                    addItem: function() {

                        var _this = this;

                        this.$http.post('/wishlist',{
                            _token:_token,
                            id:_this.item.id,
                            name:_this.item.name,
                            price:_this.item.price,
                            qty:_this.item.qty
                        }).then(function(success) {
                            _this.loadItems();
                        }, function(error) {
                            console.log(error);
                        });
                    },
                    removeItem: function(id) {

                        var _this = this;

                        this.$http.delete('/wishlist/'+id,{
                            params: {
                                _token:_token
                            }
                        }).then(function(success) {
                            _this.loadItems();
                        }, function(error) {
                            console.log(error);
                        });
                    },
                    loadItems: function() {

                        var _this = this;

                        this.$http.get('/wishlist',{
                            params: {
                                limit:10
                            }
                        }).then(function(success) {
                            _this.items = success.body.data;
                            _this.itemCount = success.body.data.length;
                            _this.loadCartDetails();
                        }, function(error) {
                            console.log(error);
                        });
                    },
                    loadCartDetails: function() {

                        var _this = this;

                        this.$http.get('/wishlist/details').then(function(success) {
                            _this.details = success.body.data;
                        }, function(error) {
                            console.log(error);
                        });
                    }
                }
            });

        });

    })(jQuery);
</script>
</body>
</html>
