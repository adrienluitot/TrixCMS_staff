<link rel="stylesheet" href="@PluginAssets('css/style.css')">

<div id="page" class="container">
    <div class="row">
        <div class="col-12">
            <h2>{{trans('staff_alfiory::user.staff')}}</h2>

            <div class="staff-members row">
                @foreach($staffMembers as $member)
                    <div class="member col-12 col-sm-6 col-md-4 col-lg-3">
                        @if(egame()->if("tx_minecraft")->isEnable())
                            <div class="img-container">
                                <img src="{{(empty($member->image_url))? "https://minotar.net/avatar/".$member->name : $member->image_url}}" alt="{{$member->name}}">
                            </div>
                        @elseif(!empty($member->image_url))
                            <div class="img-container">
                                <img src="{{$member->image_url}}" alt="{{$member->name}}">
                            </div>
                        @endif

                        <p class="name">{{$member->name}}</p>

                        @if(!empty($member->ranks_id))
                            <div class="ranks">
                                @foreach(json_decode($member->ranks_id, true) as $rankId)
                                    @if(isset($ranks[$rankId]))
                                        <div class="rank" style="background: #{{$ranks[$rankId]['color']}};">{{$ranks[$rankId]['name']}}</div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <p class="description">{!!nl2br($member->description)!!}</p>

                        @if(!empty($member->links))
                            <div class="links">
                                @foreach(json_decode($member->links, true) as $link)
                                    <a href="{{$link[0]}}" style="color: #{{$link[2]}};"><i class="{{$link[1]}}"></i></a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
