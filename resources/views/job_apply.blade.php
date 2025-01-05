<x-layouts.app>

    @slot('title')
        Job Portal | Apply Job
    @endslot
    
    <section class="section-3 py-5 bg-2 ">
        <div class="container">     
            <div class="row">
                <div class="col-6 col-md-10 ">
                    <h2>Find Jobs</h2>  
                </div>
                <div class="col-6 col-md-2">
                    <div class="align-end">
                        <select name="sort" id="sort" class="form-control handle_search_request" data-url="{{route('handle_search_request','')}}">
                            <option value="desc">Latest</option>
                            <option value="asc">Oldest</option>
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="row pt-5">
                <div class="col-md-4 col-lg-3 sidebar mb-4">
                    <div class="card border-0 shadow p-4">
                        <div class="mb-4">
                            <h2>Keywords</h2>
                            <input type="text" placeholder="Keywords" class="form-control">
                        </div>
    
                        <div class="mb-4">
                            <h2>Location</h2>
                            <input type="text" placeholder="Location" class="form-control">
                        </div>
    
                        <div class="mb-4">
                            <h2>Category</h2>
                            <select name="category" id="category" class="form-control">
                                <option value="">Select a Category</option>
                                <option value="">Engineering</option>
                                <option value="">Accountant</option>
                                <option value="">Information Technology</option>
                                <option value="">Fashion designing</option>
                            </select>
                        </div>                   
    
                        <div class="mb-4">
                            <h2>Job Type</h2>
                            <div class="form-check mb-2"> 
                                <input class="form-check-input " name="job_type" type="checkbox" value="1" id="">    
                                <label class="form-check-label " for="">Full Time</label>
                            </div>
    
                            <div class="form-check mb-2"> 
                                <input class="form-check-input school-section" name="job_type" type="checkbox" value="1" id="">    
                                <label class="form-check-label " for="">Part Time</label>
                            </div>
    
                            <div class="form-check mb-2"> 
                                <input class="form-check-input school-section" name="job_type" type="checkbox" value="1" id="">    
                                <label class="form-check-label " for="">Freelance</label>
                            </div>
    
                            <div class="form-check mb-2"> 
                                <input class="form-check-input school-section" name="job_type" type="checkbox" value="1" id="">    
                                <label class="form-check-label " for="">Remote</label>
                            </div>
                        </div>
    
                        <div class="mb-4">
                            <h2>Experience</h2>
                            <select name="category" id="category" class="form-control">
                                <option value="">Select Experience</option>
                                <option value="">1 Year</option>
                                <option value="">2 Years</option>
                                <option value="">3 Years</option>
                                <option value="">4 Years</option>
                                <option value="">5 Years</option>
                                <option value="">6 Years</option>
                                <option value="">7 Years</option>
                                <option value="">8 Years</option>
                                <option value="">9 Years</option>
                                <option value="">10 Years</option>
                                <option value="">10+ Years</option>
                            </select>
                        </div>                    
                    </div>
                </div>
                <div class="col-md-8 col-lg-9 ">
                    <div class="job_listing_area">                    
                        <div class="job_lists jobListRow">
                            <div class="row" id="job_list_view">
                                @include('filter_jobs.job_apply_filter',['jobs'=>$jobs])
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    
    </x-layouts.app>