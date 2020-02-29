<div class="profile-box search-box-left-sidebar">
    <div class="menu-title">
        <i class="fa fa-search fa-3x fa-root-menu-title"></i> <div class="menu-title-fix">Kursus Online<?php //echo $this->lang->line('search_tutor') ?></div>
    </div>

    <form action="#<?php //echo base_url('teacher/search/dropdown'); ?>" method="GET">

        <ul>
            <li>
                <select name="program" id="right-sidebar-program" class="form-control styled-select">
                    <option value="">Program</option>
                    
                </select>
            </li>
            <li>
                <select name="category" id="right-sidebar-category" class="form-control styled-select">
                    <option value="">Semua Kategori</option>
                    
                </select>
            </li>
            <li>
                <select name="topic" id="right-sidebar-topic" class="form-control styled-select">
                    <option value="">Semua Topik</option>
                    
                </select>
            </li>
            <li>  
                
                <input id="minprice" type="number" class="form-control " placeholder="harga min.">
            </li>
            <li>
                
                <input id="maxprice" type="number" class="form-control " placeholder="harga max.">
            </li>
            <li>
                <button id="btn-search-from-right-sidebar" class="home-btn-search" type="submit"><?php echo $this->lang->line('submit') ?></button>
            </li>
        </ul>

    </form>

</div>