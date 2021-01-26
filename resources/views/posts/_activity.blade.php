<div class="container">
            <div class="row">
                    <!-- <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Commented</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                What people are currently talking about
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                        {{ $post->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div> -->

                @component('components.card',
                ['title'=>'Most Commented'
                ,'subtitle'=>' What people are currently talking about'
                ])
                     @slot('items')
                     @foreach ($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                        {{ $post->title }}
                                    </a>
                                </li>
                            @endforeach     
                     @endslot
                @endcomponent
            </div>

            <div class="row mt-4">
                <!-- <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Most Active</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Users with most posts written
                        </h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostActive as $user)
                            <li class="list-group-item">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                </div> -->

                @component('components.card',
                ['title'=>'Most Active'
                ,'subtitle'=>'   Users with most posts written'
                ])
                     @slot('items',collect($mostActive)->pluck('name'))
                @endcomponent
            </div>

            <div class="row mt-4">
                <!-- <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Most Active Last Month</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Users with most posts written in the month
                        </h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostActiveLastMonth as $user)
                            <li class="list-group-item">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                </div> -->

                @component('components.card',
                ['title'=>'Most Active Last Month'
                ,'subtitle'=>' Users with most posts written in the month'
                ])
                     @slot('items',collect($mostActiveLastMonth)->pluck('name'))
                @endcomponent
            </div>
        </div>