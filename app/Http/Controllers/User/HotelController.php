<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\Rooms\Room;
use App\Models\Language;
use App\Models\Currency;
use App\Models\Setting;

class HotelController extends Controller
{
    public function getHotels(Request $request)
    {
        $sortKey = ($request->sort && $request->sort == "HP") || ($request->sort && $request->sort == "LP") ? "lowest_room_price" : "avg_rating";
        $sortWay = $request->sort && $request->sort == "HP" ? "desc" : ($request->sort && $request->sort  == "LP" ? "asc" : "desc");
        // $currency_id = 2;
        $lang = Language::where("key", $request->lang ? $request->lang : "EN")->first() ? Language::where("key", $request->lang ? $request->lang : "EN")->first() : Language::where("key", "EN")->first();
        $currency_id = Currency::find($request->currency_id) ? Currency::find($request->currency_id)->id : Currency::first()->id;

        $hotels = Hotel::with([
            "names" => function ($q) use ($lang) {
                if ($lang)
                    $q->where("language_id", $lang->id);
            },
            "descriptions" => function ($q) use ($lang) {
                if ($lang)
                    $q->where("language_id", $lang->id);
            },
            "addresses" => function ($q) use ($lang) {
                if ($lang)
                    $q->where("language_id", $lang->id);
            },
            "rooms" => function ($q) use ($lang, $currency_id) {
                $q->with(["features" => function ($q) use ($lang) {
                    $q->with(["names" => function ($qe) use ($lang) {
                        if ($lang)
                            $qe->where("language_id", $lang->id);
                    }]);
                },  "names" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                }, "descriptions" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                }, "prices" => function ($q) use ($lang, $currency_id) {
                    $q->with(['currency' => function ($Q) use ($lang) {
                        $Q->with(["names" => function ($q) use ($lang) {
                            if ($lang)
                                $q->where("language_id", $lang->id);
                        }]);
                    }])->where("currency_id", $currency_id);
                }]);
            },
            "slogans" => function ($q) use ($lang) {
                if ($lang)
                    $q->where("language_id", $lang->id);
            },

            "features" => function ($q) use ($lang) {
                $q->with(["names" => function ($qe) use ($lang) {
                    if ($lang)
                        $qe->where("language_id", $lang->id);
                }]);
            },
            "reasons" => function ($q) use ($lang) {
                $q->with(["names" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                }, "descriptions" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                }]);
            },
            "tours" => function ($q) use ($lang) {
                $q->with(["titles" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                }, "intros" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                }]);
            }
        ])->when($request->filter && $request->filter["minPrice"] && $request->filter["maxPrice"], function ($query) use ($request) {
            return $query->whereBetween('lowest_room_price', [$request->filter["minPrice"], $request->filter["maxPrice"]]);
        }, function ($query) {
            return $query; // No filtering applied if no filter is provided
        })->orderBy($sortKey, $sortWay)->get();

        return response()->json(
            $hotels,
            200
        );
    }

    public function getRomms(Request $request)
    {
        // $currency_id = 2;
        $lang = Language::where("key", $request->lang)->first();
        $hotels = Room::latest()->with(["features" => function ($q) use ($lang) {
            $q->with(["names" => function ($q) use ($lang) {
                if ($lang)
                    $q->where("language_id", $lang->id);
            }]);
        },  "names" => function ($q) use ($lang) {
            if ($lang)
                $q->where("language_id", $lang->id);
        }, "descriptions" => function ($q) use ($lang) {
            if ($lang)
                $q->where("language_id", $lang->id);
        }, "prices", "hotel" => function ($q) use ($lang) {
            $q->with([
                "ratings",
                "names" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                },
                "descriptions" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                },
                "addresses" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                },
                "rooms" => function ($q) use ($lang) {
                    $q->with(["features" => function ($q) use ($lang) {
                        $q->with(["names" => function ($qe) use ($lang) {
                            if ($lang)
                                $qe->where("language_id", $lang->id);
                        }]);
                    },  "names" => function ($q) use ($lang) {
                        if ($lang)
                            $q->where("language_id", $lang->id);
                    }, "descriptions" => function ($q) use ($lang) {
                        if ($lang)
                            $q->where("language_id", $lang->id);
                    }, "prices"]);
                },
                "slogans" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                },

                "features" => function ($q) use ($lang) {
                    $q->with(["names" => function ($qe) use ($lang) {
                        if ($lang)
                            $qe->where("language_id", $lang->id);
                    }]);
                },
                "reasons" => function ($q) use ($lang) {
                    $q->with(["names" => function ($q) use ($lang) {
                        if ($lang)
                            $q->where("language_id", $lang->id);
                    }, "descriptions" => function ($q) use ($lang) {
                        if ($lang)
                            $q->where("language_id", $lang->id);
                    }]);
                },
                "tours" => function ($q) use ($lang) {
                    $q->with(["titles" => function ($q) use ($lang) {
                        if ($lang)
                            $q->where("language_id", $lang->id);
                    }, "intros" => function ($q) use ($lang) {
                        if ($lang)
                            $q->where("language_id", $lang->id);
                    }]);
                }
            ]);
        }])->take(15)->get();

        return response()->json(
            $hotels,
            200
        );
    }

    public function getCottages(Request $request)
    {
        // $currency_id = 2;
        $lang = Language::where("key", $request->lang ? $request->lang : "EN")->first() ? Language::where("key", $request->lang ? $request->lang : "EN")->first() : Language::where("key", "EN")->first();
        $currency_id = Currency::find($request->currency_id) ? Currency::find($request->currency_id)->id : Currency::first()->id;
        $hotels = Hotel::latest()->where("type", "Cottage")->with([
            "ratings",
            "names" => function ($q) use ($lang) {
                if ($lang)
                    $q->where("language_id", $lang->id);
            },
            "descriptions" => function ($q) use ($lang) {
                if ($lang)
                    $q->where("language_id", $lang->id);
            },
            "addresses" => function ($q) use ($lang) {
                if ($lang)
                    $q->where("language_id", $lang->id);
            },
            "rooms" => function ($q) use ($lang, $currency_id) {
                $q->with(["features" => function ($q) use ($lang) {
                    $q->with(["names" => function ($qe) use ($lang) {
                        if ($lang)
                            $qe->where("language_id", $lang->id);
                    }]);
                }, "names" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                }, "descriptions" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                }, "prices" => function ($q) use ($lang, $currency_id) {
                    $q->with(['currency' => function ($Q) use ($lang) {
                        $Q->with(["names" => function ($q) use ($lang) {
                            if ($lang)
                                $q->where("language_id", $lang->id);
                        }]);
                    }])->where("currency_id", $currency_id);
                }]);
            },
            "slogans" => function ($q) use ($lang) {
                if ($lang)
                    $q->where("language_id", $lang->id);
            },

            "features" => function ($q) use ($lang) {
                $q->with(["names" => function ($qe) use ($lang) {
                    if ($lang)
                        $qe->where("language_id", $lang->id);
                }]);
            },
            "reasons" => function ($q) use ($lang) {
                $q->with(["names" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                }, "descriptions" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                }]);
            },
            "tours" => function ($q) use ($lang) {
                $q->with(["titles" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                }, "intros" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                }]);
            }
        ])->when($request->filter && $request->filter["minPrice"] && $request->filter["maxPrice"], function ($query) use ($request) {
            return $query->whereBetween('lowest_room_price', [$request->filter["minPrice"], $request->filter["maxPrice"]]);
        }, function ($query) {
            return $query; // No filtering applied if no filter is provided
        })->get();

        return response()->json(
            $hotels,
            200
        );
    }

    public function getHomeHotels(Request $request)
    {
        // $currency_id = 2;
        $lang = Language::where("key", $request->lang ? $request->lang : "EN")->first() ? Language::where("key", $request->lang ? $request->lang : "EN")->first() : Language::where("key", "EN")->first();
        $currency_id = Currency::find($request->currency_id) ? Currency::find($request->currency_id)->id : Currency::first()->id;
        $settings = Setting::first();
        $hotels = [];


        if ($settings)
            $hotels = Hotel::whereIn('id', $settings->hotels)->with([
                "ratings",
                "names" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                },
                "descriptions" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                },
                "addresses" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                },
                "rooms" => function ($q) use ($lang, $currency_id) {
                    $q->with(["features" => function ($q) use ($lang) {
                        $q->with(["names" => function ($qe) use ($lang) {
                            if ($lang)
                                $qe->where("language_id", $lang->id);
                        }]);
                    }, "names" => function ($q) use ($lang) {
                        if ($lang)
                            $q->where("language_id", $lang->id);
                    }, "descriptions" => function ($q) use ($lang) {
                        if ($lang)
                            $q->where("language_id", $lang->id);
                    }, "prices" => function ($q) use ($lang, $currency_id) {
                        $q->with(['currency' => function ($Q) use ($lang) {
                            $Q->with(["names" => function ($q) use ($lang) {
                                if ($lang)
                                    $q->where("language_id", $lang->id);
                            }]);
                        }])->where("currency_id", $currency_id);
                    }]);
                },
                "slogans" => function ($q) use ($lang) {
                    if ($lang)
                        $q->where("language_id", $lang->id);
                },

                "features" => function ($q) use ($lang) {
                    $q->with(["names" => function ($qe) use ($lang) {
                        if ($lang)
                            $qe->where("language_id", $lang->id);
                    }]);
                },
                "reasons" => function ($q) use ($lang) {
                    $q->with(["names" => function ($q) use ($lang) {
                        if ($lang)
                            $q->where("language_id", $lang->id);
                    }, "descriptions" => function ($q) use ($lang) {
                        if ($lang)
                            $q->where("language_id", $lang->id);
                    }]);
                },
                "tours" => function ($q) use ($lang) {
                    $q->with(["titles" => function ($q) use ($lang) {
                        if ($lang)
                            $q->where("language_id", $lang->id);
                    }, "intros" => function ($q) use ($lang) {
                        if ($lang)
                            $q->where("language_id", $lang->id);
                    }]);
                }
            ])->get();

        return response()->json(
            $hotels,
            200
        );
    }

    public function getHotelNearstRestaurante(Request $request)
    {
        $lang = Language::where("key", $request->lang ? $request->lang : "EN")->first();

        $hotel = Hotel::find($request->id);

        return $hotel->nearestRestaurants(10, 10, $lang);
    }
}
