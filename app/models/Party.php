<?php

class Party extends BaseModel {
	protected $guarded = array();

	public static $rules = array();

    protected $table = 'parties';

    public static function all_data()
    {
        $all_parties = Party::all();
        foreach ($all_parties as $party) {
            $party->logo = URL::to($party->logo);
            $party->vote_sign = URL::to($party->vote_sign);
            unset($party->vote);
            unset($party->created_at);
            unset($party->updated_at);
        }
        return $all_parties;
    }

    public static function name($id, $lang='en')
    {
        if (!Party::find($id)) {
            return '';
        }
        return ($lang=='en') ? Party::find($id)->name : Party::find($id)->name_ne;
    }

    /**
     * List of all parties in alphabetical order
     * @return array [description]
     */
    public static function all_list()
    {
        $parties = Party::where('id', '>', 0)->orderBy('name', 'ASC')->get(['id', 'name']);

        $ret[0] = 'All Parties';
        foreach ($parties as $party) {
            $ret[$party->id] = $party->name;
        }

        return $ret;
    }

    public static function districts()
    {
        $districts = ['Achham', 'Arghakhanchi', 'Baglung', 'Baitadi', 'Bajhang', 'Bajura', 'Banke', 'Bara', 'Bardiya', 'Bhaktapur', 'Bhojpur', 'Chitwan', 'Dadeldhura', 'Dailekh', 'Dang Deukhuri', 'Darchula', 'Dhading', 'Dhankuta', 'Dhanusa', 'Dolakha', 'Dolpa', 'Doti', 'Gorkha', 'Gulmi', 'Humla', 'Illam', 'Jajarkot', 'Jhapa', 'Jumla', 'Kailali', 'Kalikot', 'Kanchanpur', 'Kapilvastu', 'Kaski', 'Kathmandu', 'Kavrepalanchok', 'Khotang', 'Lalitpur', 'Lamjung', 'Mahottari', 'Makwanpur', 'Manang', 'Morang', 'Mugu', 'Mustang', 'Myagdi', 'Nawalparasi', 'Nuwakot', 'Okhaldhunga', 'Palpa', 'Panchthar', 'Parbat', 'Parsa', 'Pyuthan', 'Ramechhap', 'Rasuwa', 'Rautahat', 'Rolpa', 'Rukum', 'Rupandehi', 'Salyan', 'Sankhuwasabha', 'Saptari', 'Sarlahi', 'Sindhuli', 'Sindhupalchok', 'Siraha', 'Solukhumbu', 'Sunsari', 'Surkhet', 'Syangja', 'Tanahu', 'Taplejung', 'Terhathum', 'Udayapur'];

        $ret[0] = 'All Districts';
        foreach ($districts as $district) {
            $ret[$district] = $district;
        }

        return $ret;
    }
}
