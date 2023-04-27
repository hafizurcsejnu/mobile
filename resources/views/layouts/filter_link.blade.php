 <!-- filter link -->

 <div class="d-none row filter-data-list" style="display:none">
    <div class="col">
        <label for="" id="materials"></label><br/>
        <div id="materials-list">

        </div>
    </div>
    <div class="col">
        <label for="" id="brand"></label><br/>
        <div id="brand-list">

        </div>
    </div>
    <div class="col">
        <label for="" id="style"></label><br/>
        <div id="style-list">

        </div>
    </div>
    <div class="col">
        <label for="" id="usages"></label><br/>
        <div id="usages-list">

        </div>
    </div>
 </div> 
 
 <div class="d-none1 toolbox">
    <div class="toolbox-left">
        <a href="#" class="sidebar-toggler"><i class="icon-bars"></i>Filters</a>
    </div><!-- End .toolbox-left -->
    
    <!-- <div class="toolbox-center">
        <div class="toolbox-info">
            Showing <span>12 of 56</span> Models
        </div>
    </div> -->
    <div class="toolbox-center">
        {{-- <p>Showing <strong id="show_count"></strong> of <strong id="total">{{$total}}</strong> products</p> --}}
        <p>Total <strong id="total">{{$total}}</strong> products</p>
    </div>
    <div class="d-none toolbox-right">
        <div class="toolbox-sort">
            <label for="sortby">Sort by:</label>
            <div class="select-custom">
                <select name="sortby" id="sortby" class="form-control">
                    <option value="popularity" selected="selected">Most Popular</option>
                    <option value="date">Date</option>
                </select>
            </div>
        </div><!-- End .toolbox-sort -->
    </div><!-- End .toolbox-right -->
</div>
<!-- End filter link -->