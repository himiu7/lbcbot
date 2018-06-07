<?php
/**
 * Local bitcoins api description
 */

return [
    "name"=> "LocalBtc",
    "apiVersion"=> "2013-10-15",
    "baseUrl"=> "https=>//localbitcoins.com",
    "description"=> "An API to access LocalBitcoins.com",
    "operations"=> [
        "accountInfo"=> [
            "httpMethod"=> "GET",
            "uri"=> "/api/account_info/{username}/",
            "summary"=> "Returns the public profile of a user",
            "responseModel"=> "GenericOutput",
            "parameters"=> [
                "username"=> [
                    "location"=> "uri",
                    "description"=> "The username of a user",
                    "required"=> true
                ]
            ]
        ],
        "myself"=> [
            "httpMethod"=> "GET",
            "uri"=> "/api/myself/",
            "summary"=> "Return the information of the current user",
            "responseModel"=> "GenericOutput"
        ],
        "chartAverage"=> [
            "httpMethod"=> "GET",
            "uri"=> "/bitcoinaverage/ticker-all-currencies/",
            "summary"=> "Returns a ticker-tape like list of all completed trades.",
            "responseModel"=> "GenericOutput"
        ],
        "chartTrades"=> [
            "httpMethod"=> "GET",
            "uri"=> "/bitcoincharts/{currency}/trades.json",
            "summary"=> "All closed trades in online buy and online sell categories, updated every 15 minutes.",
            "responseModel"=> "GenericOutput",
            "parameters"=> [
                "currency"=> [
                    "location"=> "uri",
                    "required"=> true,
                    "default"=> "UAH"
                ],
                "since"=> [
                    "location"=> "query",
                    "required"=>false
                ]
            ]
        ],
        "chartOrders"=> [
            "httpMethod"=> "GET",
            "uri"=> "/bitcoincharts/{currency}/orderbook.json",
            "summary"=> "Buy and sell bitcoin online advertisements. Amount is the maximum amount available for the
                        trade request. Price is the hourly updated price. The price is based on the price equation and
                        commission % entered by the ad author.",
            "responseModel"=> "GenericOutput",
            "parameters"=> [
                "currency"=> [
                    "location"=> "uri",
                    "required"=> true,
                    "default"=> "UAH"
                ]
            ]
        ],

        "onlineBuy"=> [
            "httpMethod"=> "GET",
            "uri"=> "/buy-bitcoins-online/.json",
            "summary"=> "This API returns buy Bitcoin online ads",
            "responseModel"=> "GenericOutput",
            "parameters"=> [
                "page"=> [
                    "location"=> "query",
                    "required"=> false
                ]
            ]
        ],
        "onlineBuyCountry"=> [
            "httpMethod"=> "GET",
            "uri"=> "/buy-bitcoins-online/{countrycode}/{country_name}/{payment_method}/.json",
            "summary"=> "This API returns buy Bitcoin online ads.",
            "responseModel"=> "GenericOutput",
            "parameters"=> [
                "countrycode"=> [
                    "location"=> "uri",
                    "required"=> true,
                    "default"=> "UA"
                ],
                "country_name"=> [
                    "location"=> "uri",
                    "required"=> true,
                    "default"=> "Ukraine"
                ],
                "payment_method" => [
                    "location"=> "uri",
                    "required"=> false,
                ]
            ]
        ],
        "onlineBuyCurrency"=> [
            "httpMethod"=> "GET",
            "uri"=> "/buy-bitcoins-online/{currency}/{payment_method}/.json",
            "summary"=> "This API returns buy Bitcoin online ads.",
            "responseModel"=> "GenericOutput",
            "parameters"=> [
                "currency"=> [
                    "location"=> "uri",
                    "required"=> true,
                    "default"=> "UAH"
                ],
                "payment_method" => [
                    "location"=> "uri",
                    "required"=> false
                ]
            ]
        ],
        "onlineSell"=> [
            "httpMethod"=> "GET",
            "uri"=> "/sell-bitcoins-online/.json",
            "summary"=> "This API returns sell Bitcoin online ads",
            "responseModel"=> "GenericOutput",
            "parameters"=> [
                "page"=> [
                    "location"=> "query",
                    "required"=> false
                ],
            ]
        ],
        "onlineSellCountry"=> [
            "httpMethod"=> "GET",
            "uri"=> "/sell-bitcoins-online/{countrycode}/{country_name}/{payment_method}/.json",
            "summary"=> "This API returns buy Bitcoin online ads.",
            "responseModel"=> "GenericOutput",
            "parameters"=> [
                "countrycode"=> [
                    "location"=> "uri",
                    "required"=> true,
                    "default"=> "UA"
                ],
                "country_name"=> [
                    "location"=> "uri",
                    "required"=> true,
                    "default"=> "Ukraine"
                ],
                "payment_method" => [
                    "location"=> "uri",
                    "required"=> false,
                ]
            ]
        ],
        "onlineSellCurrency"=> [
            "httpMethod"=> "GET",
            "uri"=> "/sell-bitcoins-online/{currency}/{payment_method}/.json",
            "summary"=> "This API returns sell Bitcoin online ads.",
            "responseModel"=> "GenericOutput",
            "parameters"=> [
                "currency"=> [
                    "location"=> "uri",
                    "required"=> true,
                    "default"=> "UAH"
                ],
                "payment_method" => [
                    "location"=> "uri",
                    "required"=> false,
                ]
            ]
        ],
        "adUpdate"=> [
            "httpMethod"=> "POST",
            "uri"=> "/api/ad/{ad_id}/",
            "summary"=> "Update Ad",
            "responseModel"=> "GenericOutput",
            "parameters"=> [
                "ad_id"=> [
                    "location"=> "uri",
                    "description"=> "Ad id",
                    "required"=> true
                ],
                "price_equation"=> [
                    "location"=> "postField",
                    // String	Price equation formula
                ],
                "lat"=> [
                    "location"=> "postField",
                    //Integer	Latitude coordinate
                ],
                "lon"=> [
                    "location"=> "postField",
                    //Integer	Longitude coordinate
                ],
                "city"=> [
                    "location"=> "postField",
                    //String	City name
                ],
                "location_string"=> [
                    "location"=> "postField",
                    //String	Human readable location text.
                ],
                "countrycode"=> [
                    "location"=> "postField",
                    //String	Two-character country code. See valid country codes
                ],
                "currency"=> [
                    "location"=> "postField",
                    //String	Three letter currency code. See list of valid currencies
                ],
                //account_info	String	-
                "bank_name"=> [
                    "location"=> "postField",
                    //  String	Certain of the online payment methods require bank_name to be chosen from a limited set of names.
                    // To find out these limited choices, use this public API request /api/payment_methods/
                ],
                "msg"=> [
                    "location"=> "postField",
                    //	String	Terms of trade of the advertisement
                ],
                "sms_verification_required"=> [
                    "location"=> "postField",
                    //	Boolean	0 for false, 1 for true.
                ],
                "track_max_amount"=> [
                    "location"=> "postField",
                    //	Boolean	0 for false, 1 for true.
                ],
                "require_trusted_by_advertiser"=> [
                    "location"=> "postField",
                    //	Boolean	0 for false, 1 for true.
                ],
                "require_identification"=> [
                    "location"=> "postField",
                    //	Boolean	0 for false, 1 for true.
                ],
                //Optional arguments
                "min_amount"=> [
                    "location"=> "postField",
                    //	Integer	Minimum transaction limit in fiat.
                ],
                "max_amount"=> [
                    "location"=> "postField",
                    //	Integer	Maximum transaction limit in fiat.
                ],
                "opening_hours"=> [
                    "location"=> "postField",
                    //	JSON array	Times when ad is visible (Set according to timezone set with token owners account).
                ],
                "limit_to_fiat_amounts"=> [
                    "location"=> "postField",
                    //	String	Comma separated fiat value list of amounts to restrict. Same as "Restrict amounts to" on site.
                ],
                "visible"=> [
                    "location"=> "postField",
                    //	Boolean	0 for false, 1 for true.
                ]
            ]
        ],
        "adUpdateEquation" => [
            "httpMethod"=> "POST",
            "uri"=> "/api/ad-equation/{ad_id}/",
            "summary"=> "Update Ad Equation",
            "responseModel"=> "GenericOutput",
            "parameters"=> [
                "ad_id"=> [
                    "location"=> "uri",
                    "description"=> "Ad id",
                    "required"=> true
                ],
                "price_equation"=> [
                    "location"=> "postField",
                    // String	Price equation formula
                ]
            ]
        ]
    ],
    "models"=> [
        "GenericOutput"=> [
            "type"=> "object",
            'additionalProperties' => [
                'location' => 'json'
            ]
        ]
     ]
];