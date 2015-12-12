<?php

class HomeController extends BaseController {

    public function index()
    {
        return View::make('home');
    }

    public function faq()
    {
        return View::make('pages.faq');
    }

    public function support()
    {
        return View::make('pages.support');
    }

    /**
     * POST /support
     * Sends an email from contact form on support page
     */
    public function contact()
    {
        try{
            $email = Input::get('email');
            $name = Input::get('name');
            $phone = Input::get('phone_number');
            $mbody = Input::get('message');
            $data['body'] = "You have a new contact form message from CompanyExchange.<br>Sender name: $name<br>Sender email: $email<br>Sender phone: $phone<br><br>Message:<br>$mbody";
            $data['title'] = 'New visitor message on CompanyExchange';
            Mail::queue('emails.templates.custom', $data, function($message) use($email, $name){
                $message->from($email, $name);
                $message->to('opatachibueze@gmail.com');
                $message->subject('[CompanyExchange] New Visitor Message');
            });
            Alert::info('Your message has been sent successfully.', 'Thank you.');
            return View::make('pages.support')->withSuccess('Your message has been sent successfully. Thank you.');
        }
        catch(\Exception $e)
        {
            \Log::debug($e);
            return View::make('pages.support')->withError('Failed to send message. If problem persists please manually contact us at info@listings.ng.cx');
        }
    }
}
