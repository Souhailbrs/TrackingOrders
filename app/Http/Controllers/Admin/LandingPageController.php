<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\LandingSection;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addFields()
    {
        //home page
        $home_page = ['title_ar', 'title_en', 'details_ar', 'details_en', 'logo_white', 'logo_black', 'background'];
        $features = ['title_ar', 'title_en', 'details_ar', 'details_en', 'feature_title_ar_1', 'feature_title_en_1', 'feature_description_ar_1', 'feature_description_en_1', 'feature_title_ar_2', 'feature_title_en_2', 'feature_description_ar_2', 'feature_description_en_2', 'feature_title_ar_3', 'feature_title_en_3', 'feature_description_ar_3', 'feature_description_en_3','feature_title_ar_4', 'feature_title_en_4', 'feature_description_ar_4', 'feature_description_en_4'];
        $experience = ['title_ar', 'title_en',
            'details_ar', 'details_en',
            'headline_title_ar_1', 'headline_title_ar_2', 'headline_title_ar_3', 'headline_title_en_1', 'headline_title_en_2', 'headline_title_en_3',
            'headline_description_ar_1', 'headline_description_ar_2', 'headline_description_ar_3', 'headline_description_en_1', 'headline_description_en_2', 'headline_description_en_3',
            'image'
        ];
        $screens = ['title_ar', 'title_en', 'details_ar', 'details_en', 'images'];
        $faq = ['title_ar', 'title_en', 'details_ar', 'details_en',
            'headline_title_ar_1', 'headline_title_ar_2', 'headline_title_ar_3', 'headline_title_en_1', 'headline_title_en_2', 'headline_title_en_3',
            'headline_description_ar_1', 'headline_description_ar_2', 'headline_description_ar_3', 'headline_description_en_1', 'headline_description_en_2', 'headline_description_en_3',
            'image'
        ];
        $feedback = ['title_ar', 'title_en', 'details_ar', 'details_en'];
        $team = ['title_ar', 'title_en', 'details_ar', 'details_en'];
        $pricing = ['title_ar', 'title_en', 'details_ar', 'details_en'];
        $contact = ['location', 'address_ar', 'address_en', 'phone1', 'phone2', 'email1', 'email2',
            'facebook_account',
            'twitter_account',
            'instagram_account',
            'linked_account'
        ];

        $all_sections = [
            'home_page' => $home_page,
            'features' => $features,
            'experience' => $experience,
            'screens' => $screens,
            'faq' => $faq,
            'feedback' => $feedback,
            'team' => $team,
            'pricing' => $pricing,
            'contact' => $contact
        ];
        foreach ($all_sections as $key => $value) {
            LandingPage::create([
                'section' => $key,
                'value' => 1
            ]);
            $this->addSection($value, $key);
        }
    }

    public function addSection($array, $page)
    {
        foreach ($array as $arr) {
            LandingSection::create([
                'section' => $page,
                'field' => $arr,
                'value' => 'default_' . $arr
            ]);
        }
    }
    public function controlPages(){
        $values = LandingPage::get();
        return view('admin.landingPage.all_pages', compact('values'));
    }
    public function controlPagesUpdate( Request $request){
        $values = LandingPage::get();
        $res = [];
        foreach ($values as $val) {
         if($request['pages'. $val->id]){
             $val->update([
                'value'=>1
             ]);
         }else{
             $val->update([
                 'value'=>0
             ]);
         }
        }
        return redirect()->back()->with('success','Done Successfuly');

    }
    public function getPage($name)
    {
        $values = LandingSection::where('section', $name)->get();
        switch ($name) {
            case 'home_page':
                return view('admin.landingPage.homePage', compact('values', 'name'));
            case 'features':
                return view('admin.landingPage.features', compact('values', 'name'));
            case 'experience':
                return view('admin.landingPage.experience', compact('values', 'name'));
            case 'screens':
                return view('admin.landingPage.screens', compact('values', 'name'));
            case 'faq':
                return view('admin.landingPage.faq', compact('values', 'name'));
            case 'feedback':
                return view('admin.landingPage.feedback', compact('values', 'name'));
            case 'team':
                return view('admin.landingPage.team', compact('values', 'name'));
            case 'contact':
                return view('admin.landingPage.contact', compact('values', 'name'));
            default:
                return redirect()->route('admin.home');
        }
    }

    public function updatePage(Request $request)
    {
        $name = $request->section;
        $sections = LandingSection::where('section', $name)->get();
        switch ($name) {
            case 'home_page':
                foreach ($sections as $sec) {
                    if ($sec->field == 'title_ar') {
                        $sec->update([
                            'value' => $request->title_ar
                        ]);
                    } elseif ($sec->field == 'title_en') {
                        $sec->update([
                            'value' => $request->title_en
                        ]);
                    } elseif ($sec->field == 'details_ar') {
                        $sec->update([
                            'value' => $request->details_ar
                        ]);
                    } elseif ($sec->field == 'details_en') {
                        $sec->update([
                            'value' => $request->details_en
                        ]);
                    } elseif ($sec->field == 'logo_black') {
                        if($request->logo_black) {
                            $fileName = $request->logo_black->getClientOriginalName();
                            $file_to_store = time() . '_' . $fileName ;
                            $request->logo_black->move(public_path('assets/site/images/main_images'), $file_to_store);

                            $sec->update([
                                'value' => $file_to_store
                            ]);
                        }
                    } elseif ($sec->field == 'logo_white') {
                        if($request->logo_white) {
                            $fileName1 = $request->logo_white->getClientOriginalName();
                            $file_to_store1 = time() . '_' . $fileName1 ;
                            $request->logo_white->move(public_path('assets/site/images/main_images'), $file_to_store1);

                            $sec->update([
                                'value' => $file_to_store1
                            ]);
                        }
                    } elseif ($sec->field == 'background') {
                        if($request->background) {
                            $fileName2 = $request->background->getClientOriginalName();
                            $file_to_store2 = time() . '_' . $fileName2 ;
                            $request->background->move(public_path('assets/site/images/main_images'), $file_to_store2);

                            $sec->update([
                                'value' =>$file_to_store2
                            ]);
                        }
                    }
                }
                return redirect()->back()->with('success', 'done successfully');
            case 'features':
                    foreach ($sections as $sec) {
                        if ($sec->field == 'title_ar') {
                            $sec->update([
                                'value' => $request->title_ar
                            ]);
                        } elseif ($sec->field == 'title_en') {
                            $sec->update([
                                'value' => $request->title_en
                            ]);
                        } elseif ($sec->field == 'details_ar') {
                            $sec->update([
                                'value' => $request->details_ar
                            ]);
                        } elseif ($sec->field == 'details_en') {
                            $sec->update([
                                'value' => $request->details_en
                            ]);
                        } elseif ($sec->field == 'feature_title_ar_1') {
                            $sec->update([
                                'value' => $request->feature_title_ar_1
                            ]);
                        } elseif ($sec->field == 'feature_title_en_1') {
                            $sec->update([
                                'value' => $request->feature_title_en_1
                            ]);
                        } elseif ($sec->field == 'feature_title_ar_2') {
                            $sec->update([
                                'value' => $request->feature_title_ar_2
                            ]);
                        } elseif ($sec->field == 'feature_title_en_2') {
                            $sec->update([
                                'value' => $request->feature_title_en_2
                            ]);
                        } elseif ($sec->field == 'feature_title_ar_3') {
                            $sec->update([
                                'value' => $request->feature_title_ar_3
                            ]);
                        } elseif ($sec->field == 'feature_title_en_3') {
                            $sec->update([
                                'value' => $request->feature_title_en_3
                            ]);
                        } elseif ($sec->field == 'feature_title_ar_4') {
                            $sec->update([
                                'value' => $request->feature_title_ar_4
                            ]);
                        } elseif ($sec->field == 'feature_title_en_4') {
                            $sec->update([
                                'value' => $request->feature_title_en_4
                            ]);
                        } elseif ($sec->field == 'feature_description_ar_1') {
                            $sec->update([
                                'value' => $request->feature_description_ar_1
                            ]);
                        } elseif ($sec->field == 'feature_description_en_1') {
                            $sec->update([
                                'value' => $request->feature_description_en_1
                            ]);
                        } elseif ($sec->field == 'feature_description_ar_2') {
                            $sec->update([
                                'value' => $request->feature_description_ar_2
                            ]);
                        } elseif ($sec->field == 'feature_description_en_2') {
                            $sec->update([
                                'value' => $request->feature_description_en_2
                            ]);
                        } elseif ($sec->field == 'feature_description_ar_3') {
                            $sec->update([
                                'value' => $request->feature_description_ar_3
                            ]);
                        } elseif ($sec->field == 'feature_description_en_3') {
                            $sec->update([
                                'value' => $request->feature_description_en_3
                            ]);
                        } elseif ($sec->field == 'feature_description_ar_4') {
                            $sec->update([
                                'value' => $request->feature_description_ar_4
                            ]);
                        } elseif ($sec->field == 'feature_description_en_4') {
                            $sec->update([
                                'value' => $request->feature_description_en_4
                            ]);
                        }
                    }
                    return redirect()->back()->with('success', 'done successfully');
            case 'experience':
                foreach ($sections as $sec) {
                    if ($sec->field == 'title_ar') {
                        $sec->update([
                            'value' => $request->title_ar
                        ]);
                    } elseif ($sec->field == 'title_en') {
                        $sec->update([
                            'value' => $request->title_en
                        ]);
                    } elseif ($sec->field == 'details_ar') {
                        $sec->update([
                            'value' => $request->details_ar
                        ]);
                    } elseif ($sec->field == 'details_en') {
                        $sec->update([
                            'value' => $request->details_en
                        ]);
                    } elseif ($sec->field == 'headline_title_ar_1') {
                        $sec->update([
                            'value' => $request->headline_title_ar_1
                        ]);
                    } elseif ($sec->field == 'headline_title_en_1') {
                        $sec->update([
                            'value' => $request->headline_title_en_1
                        ]);
                    } elseif ($sec->field == 'headline_title_ar_2') {
                        $sec->update([
                            'value' => $request->headline_title_ar_2
                        ]);
                    } elseif ($sec->field == 'headline_title_en_2') {
                        $sec->update([
                            'value' => $request->headline_title_en_2
                        ]);
                    } elseif ($sec->field == 'headline_title_ar_3') {
                        $sec->update([
                            'value' => $request->headline_title_ar_3
                        ]);
                    } elseif ($sec->field == 'headline_title_en_3') {
                        $sec->update([
                            'value' => $request->headline_title_en_3
                        ]);
                    } elseif ($sec->field == 'headline_description_ar_1') {
                        $sec->update([
                            'value' => $request->headline_description_ar_1
                        ]);
                    } elseif ($sec->field == 'headline_description_en_1') {
                        $sec->update([
                            'value' => $request->headline_description_en_1
                        ]);
                    } elseif ($sec->field == 'headline_description_ar_2') {
                        $sec->update([
                            'value' => $request->headline_description_ar_2
                        ]);
                    } elseif ($sec->field == 'headline_description_en_2') {
                        $sec->update([
                            'value' => $request->headline_description_en_2
                        ]);
                    } elseif ($sec->field == 'headline_description_ar_3') {
                        $sec->update([
                            'value' => $request->headline_description_ar_3
                        ]);
                    } elseif ($sec->field == 'headline_description_en_3') {
                        $sec->update([
                            'value' => $request->headline_description_en_3
                        ]);
                    } elseif ($sec->field == 'image') {
                        if ($request->image) {
                            $fileName = $request->image->getClientOriginalName();
                            $file_to_store = time() . '_' . $fileName;
                            $request->image->move(public_path('assets/site/images/main_images'), $file_to_store);

                            $sec->update([
                                'value' => $file_to_store
                            ]);
                        }
                    }
                }
                return redirect()->back()->with('success', 'done successfully');
            case 'screens':
                foreach ($sections as $sec) {
                    if ($sec->field == 'title_ar') {
                        $sec->update([
                            'value' => $request->title_ar
                        ]);
                    } elseif ($sec->field == 'title_en') {
                        $sec->update([
                            'value' => $request->title_en
                        ]);
                    } elseif ($sec->field == 'details_ar') {
                        $sec->update([
                            'value' => $request->details_ar
                        ]);
                    } elseif ($sec->field == 'details_en') {
                        $sec->update([
                            'value' => $request->details_en
                        ]);
                    }
                }
                return redirect()->back()->with('success', 'done successfully');
            case 'faq':
                foreach ($sections as $sec) {
                    if ($sec->field == 'title_ar') {
                        $sec->update([
                            'value' => $request->title_ar
                        ]);
                    } elseif ($sec->field == 'title_en') {
                        $sec->update([
                            'value' => $request->title_en
                        ]);
                    } elseif ($sec->field == 'details_ar') {
                        $sec->update([
                            'value' => $request->details_ar
                        ]);
                    } elseif ($sec->field == 'details_en') {
                        $sec->update([
                            'value' => $request->details_en
                        ]);
                    } elseif ($sec->field == 'headline_title_ar_1') {
                        $sec->update([
                            'value' => $request->headline_title_ar_1
                        ]);
                    } elseif ($sec->field == 'headline_title_ar_2') {
                        $sec->update([
                            'value' => $request->headline_title_ar_2
                        ]);
                    } elseif ($sec->field == 'headline_title_ar_3') {
                        $sec->update([
                            'value' => $request->headline_title_ar_3
                        ]);
                    } elseif ($sec->field == 'headline_title_en_1') {
                        $sec->update([
                            'value' => $request->headline_title_en_1
                        ]);
                    } elseif ($sec->field == 'headline_title_en_2') {
                        $sec->update([
                            'value' => $request->headline_title_en_2
                        ]);
                    } elseif ($sec->field == 'headline_title_en_3') {
                        $sec->update([
                            'value' => $request->headline_title_en_3
                        ]);
                    } elseif ($sec->field == 'headline_description_ar_1') {
                        $sec->update([
                            'value' => $request->headline_description_ar_1
                        ]);
                    } elseif ($sec->field == 'headline_description_ar_2') {
                        $sec->update([
                            'value' => $request->headline_description_ar_2
                        ]);
                    } elseif ($sec->field == 'headline_description_ar_3') {
                        $sec->update([
                            'value' => $request->headline_description_ar_3
                        ]);
                    } elseif ($sec->field == 'headline_description_en_1') {
                        $sec->update([
                            'value' => $request->headline_description_en_1
                        ]);
                    } elseif ($sec->field == 'headline_description_en_2') {
                        $sec->update([
                            'value' => $request->headline_description_en_2
                        ]);
                    } elseif ($sec->field == 'headline_description_en_3') {
                        $sec->update([
                            'value' => $request->headline_description_en_3
                        ]);
                    } elseif ($sec->field == 'image') {
                        if ($request->image) {
                            $fileName = $request->image->getClientOriginalName();
                            $file_to_store = time() . '_' . $fileName;
                            $request->image->move(public_path('assets/site/images/main_images'), $file_to_store);

                            $sec->update([
                                'value' => $file_to_store
                            ]);
                        }
                    }
                    }
                return redirect()->back()->with('success', 'done successfully');
            case 'contact':
                foreach ($sections as $sec) {
                    if ($sec->field == 'location') {
                        $sec->update([
                            'value' => $request->location
                        ]);
                    } elseif ($sec->field == 'address_ar') {
                        $sec->update([
                            'value' => $request->address_ar
                        ]);
                    } elseif ($sec->field == 'address_en') {
                        $sec->update([
                            'value' => $request->address_en
                        ]);
                    } elseif ($sec->field == 'address_ar') {
                        $sec->update([
                            'value' => $request->address_ar
                        ]);
                    } elseif ($sec->field == 'phone1') {
                        $sec->update([
                            'value' => $request->phone1
                        ]);
                    } elseif ($sec->field == 'phone2') {
                        $sec->update([
                            'value' => $request->phone2
                        ]);
                    } elseif ($sec->field == 'email1') {
                        $sec->update([
                            'value' => $request->email1
                        ]);
                    } elseif ($sec->field == 'email2') {
                        $sec->update([
                            'value' => $request->email2
                        ]);
                    } elseif ($sec->field == 'facebook_account') {
                        $sec->update([
                            'value' => $request->facebook_account
                        ]);
                    } elseif ($sec->field == 'twitter_account') {
                        $sec->update([
                            'value' => $request->twitter_account
                        ]);
                    } elseif ($sec->field == 'instagram_account') {
                        $sec->update([
                            'value' => $request->instagram_account
                        ]);
                    } elseif ($sec->field == 'linked_account') {
                        $sec->update([
                            'value' => $request->linked_account
                        ]);
                    }
                }
                return redirect()->back()->with('success', 'done successfully');
            default:
                    return redirect()->route('admin.home');
                }
        }
        public
        function index()
        {
            //
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public
        function create()
        {
            //
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public
        function store(Request $request)
        {
            //
        }

        /**
         * Display the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public
        function show($id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public
        function edit($id)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public
        function update(Request $request, $id)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public
        function destroy($id)
        {
            //
        }
    }
