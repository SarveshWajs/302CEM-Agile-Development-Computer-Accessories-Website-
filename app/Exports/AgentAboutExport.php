<?php

namespace App\Exports;

use App\Merchant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Auth, DB;

class AgentAboutExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $start, $end;

	function __construct($start, $end) {
	    
	}

    public function view(): View
    {
        $merchants = Merchant::select('l.agent_lvl AS l_agent_lvl', 'merchants.*')
                             ->leftJoin('agent_levels AS l', 'l.id', 'merchants.lvl')
                             ->get();

        return view('backend.merchants.download_agent_about', ['merchants'=>$merchants]);
    }
}
