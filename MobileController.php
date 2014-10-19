<?php

class MobileController extends \BaseController
{
   public function getid()
	{

             try
		
	{
             if(Auth::check())
              $name=Auth::user()->id;
		else
               return "nothing";

	}
	catch(Exception $e)
	{
  	 return $e;
 
	}
            return $name;

	}


   public function login()
   {
       $credentials = array('username' => Input::get('uname'),'password' => Input::get('pwd'));

       // Try to authenticate the user, remember me is set to false
       //$user = Sentry::authenticate($credentials, false);

       Auth::attempt($credentials);

       if(Auth::check())
       {
           if(Auth::user()->activated)
           {
               $user = Auth::user();
               $user->isOnline = true;
               $user->save();

              $arr=Array("ok"=>"true","id"=>Auth::user()->id,"first_name"=>Auth::user()->first_name,"last_name"=>Auth::user()->last_name);

       return json_encode($arr);
            

           }
           else
           {
                 $arr=Array("ok"=>"not activated");

                   return json_encode($content);

           }
       }
       //if everything went okay, we redirect to index route with success message
       else
       {
           $arr=Array("ok"=>"Invalid Username or Password");
           return $arr;
       }
   }

    public function create()
    {
      try
	{

        $user=Input::get('userid');
        $title=Input::get('title');
        $content=Input::get('content');

        $mobile =new Mobile();
        $mobile->userid=$user;
        $mobile->title=$title;
        $mobile->text=$content;
        $mobile->save();

        return "true";
    }
      catch(Exception $e)
	{
             return $e;
    }

    }

     public function delete()
	{

       try
{
            $id=Input::get('id');
     
      $content=Mobile::find($id);
        
//    $content =DB::table('mobilea')->where('id','=',Input::get('id'))->first();
        
      $content->delete();
      
     return "true";
 
 }
catch(Exception $e)
{
    return $e;     
}

        }

    public function getAll()
    {
        $titles=DB::table('mobilea')->get();
      
        return $titles;
    }


    public function getContent()
    {
       $content =DB::table('mobilea')->where('id','=',Input::get('id'))->first();

       return json_encode($content);

    }



}