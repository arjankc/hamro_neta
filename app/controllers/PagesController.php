<?php

class PagesController extends BaseController {
    public function getTerms()
    {
        if (Request::ajax()) {
          return View::make("site.pages.toc")
                    ->with('title','Terms & Conditions');
        } else {
          return View::make("site.pages.page")
                      ->with('title','Terms & Conditions')
                      ->with('page', 'toc');
        }
    }

    public function getPrivacy()
    {
        if (Request::ajax()) {
          return View::make("site.pages.privacy")
                    ->with('title','Privacy policies');
        } else {
          return View::make("site.pages.page")
                      ->with('title','Privacy policies')
                      ->with('page', 'privacy');
        }
    }

    public function knowUs()
    {
        if (Request::ajax()) {
          return View::make("site.pages.know")
                    ->with('title','About Us');
        } else {
          return View::make("site.pages.page")
                      ->with('title','About Us')
                      ->with('page', 'know');
        }
    }
    

    public function helpUs()
    {
        if (Request::ajax()) {
          return View::make("site.pages.help_us")
                    ->with('title','How you can help us');
        } else {
          return View::make("site.pages.page")
                      ->with('title','How you can help us')
                      ->with('page', 'help_us');
        }
    }

    public function getTestimonials()
    {
        if (Request::ajax()) {
            return View::make("site.pages.testimonials")
                            ->with('title', 'Testimonials');
        } else {
            return View::make("site.pages.page")
                      ->with('title','Testimonials')
                      ->with('page', 'testimonials');
        }
    }

    public function getTestimonial($name)
    {
        if ($name == 'anil_shah') {
            $title = 'Testimonial by Anil Shah';
        }else if($name == 'shital_moktan'){
        	$title = 'Testimonial by Shital Moktan';
        } else {
            App::abort('404');
        }
        if (Request::ajax()) {
            return View::make("site.pages.testimonials.$name")
                            ->with('title', $title);
        } else {
            return View::make("site.pages.page")
                      ->with('title',$title)
                      ->with('page', "testimonials.$name");
        }
    }

    public function getFeedback()
    {
        if (Request::ajax()) {
          return View::make("site.pages.feedback")
                            ->with('title','Feedback');
        } else {
          return View::make("site.pages.page")
                      ->with('title','Feedback')
                      ->with('page', 'feedback');
        }
    }

    public function postFeedback()
    {
        $data = Input::all();
        $rules = array(
                    'name'    => 'required',
                    'address' => 'required',
                    'email'   => 'required|email',
                    'phone'   => 'required',
                    'queries' => 'required',
                );

        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            if (Request::ajax()) {
                $message = '';
                foreach ($validation->messages()->all() as $msg) {
                    $message .= $msg . '<br>';
                }

                return "<div class='alert alert-error'>" . $message . "</div>";
            }
            return Redirect::back()->withInput()->withErrors($validation);
        }

        Mail::send('emails.feedback', $data, function($message) use ($data) {
            $message->from($data['email'], $data['name']);

            $message->to('info@hamroneta.com', 'Hamro Neta')->subject('Feedback');
        });

        if (Request::ajax()) {
            return "<div class='alert alert-success'>Thank you for your feedback.</div>";
        } else {
            Notification::success('Thank you for your feedback.');
            return Redirect::back();
        }
    }
}