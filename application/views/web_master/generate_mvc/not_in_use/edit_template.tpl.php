<?php
    /***
    * Method to Display and Save Updated information
    * This have to sections: 
    *  >>Displaying Values in Form for modifying entry.
    *  >>Saving the new information into DB
    * After Posting the form, the posted values must be
    * shown in the form if any error occurs to avoid re-entry of the form.
    * 
    * On Success redirect to the showList interface else display error here. 
    * @param int $i_id, id of the record to be modified.
    */      

    public function modify_information($i_id=0)
    {
        try
        {
            $this->data['title']        = addslashes(t("Edit News"));//Browser Title
            $this->data['heading']      = addslashes(t("Edit News"));
            $this->data['pathtoclass']  = $this->pathtoclass;
            $this->data['BREADCRUMB']   = array(addslashes(t('Edit Information')));
            $this->data['mode']="edit";                

            //Submitted Form//
            if($_POST)
            {
                $posted = array();

                $posted["s_title"]                = $this->input->post("s_title", true);
                $posted["s_details"]        = $this->input->post("s_details", true);
                $posted["dt_posted_date"]   = $this->input->post("dt_posted_date", true);
                $posted["s_place"]          = $this->input->post("s_place", true);
                $posted["h_profile_photo"]  = $this->input->post("h_profile_photo");
                $posted["h_id"]                    = $this->input->post("h_id", true);
                

                $this->form_validation->set_rules('s_title', addslashes(t('Employee name')), 'required|xss_clean');
                $this->form_validation->set_rules('s_details', addslashes(t('Employee designation')), 'required|xss_clean');
                
                if(isset($_FILES['s_image']) && !empty($_FILES['s_image']['name']))
                {
                    $s_uploaded = get_file_uploaded( $this->uploaddir,'s_image','','',$this->allowedExt);                
                    $arr_upload = explode('|',$s_uploaded);    
                }

                if($this->form_validation->run() == FALSE || $arr_upload[0]==='err')//invalid
                {
                    if($arr_upload[0]==='err')
                    {
                        set_error_msg($arr_upload[2]);
                    }
                    else
                    {
                        get_file_deleted($this->uploaddir,$arr_upload[2]);
                    }
                    //Display the add form with posted values within it//
                    $this->data["posted"] = $posted;
                }
                else//validated, now save into DB
                {
                    $info = array();

                    $info["s_title"]        = $posted['s_title'];
                    $info["s_details"]        = $posted['s_details'];                    
                    $info["dt_posted_date"]    = $posted['dt_posted_date'];
                    $info["s_place"]        = $posted["s_place"];
                    
                    
                    if(count($arr_upload)==0)
                    {
                        $info["s_image"] = $posted['h_profile_photo'];
                    }
                    else
                    {
                        $info["s_image"] = $arr_upload[2];
                    }            

                    $i_aff = $this->dw_model->edit_data($this->tbl,$info,array('i_id'=>decrypt($posted["h_id"])));

                    if($i_aff)//saved successfully
                    {                    
                        if($arr_upload[0]==='ok')
                        {
                            get_image_thumb($this->uploaddir.$info["s_image"], $this->thumbdir, 'thumb_'.$info["s_image"],$this->thumbHt,$this->thumbWd);
                            get_file_deleted($this->uploaddir,$posted['h_profile_photo']);
                            get_file_deleted($this->thumbdir,'thumb_'.$posted['h_profile_photo']);
                        }
                    

                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list/".$this->session->userdata('last_uri'));
                    }
                    else//Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted, $i_aff);
                }
            }
            else
            {
                $info = $this->mod_rect->fetch_this(decrypt($i_id));    
                
                $posted = $info[0];

                $posted['h_mode'] = $this->data['mode'];

                $posted["h_id"] = $i_id;
                
                $this->data["thumbDir"]    = $this->thumbDisplayPath;

                $this->data["posted"] = $posted;   

                unset($info,$posted);      

            }

            //end Submitted Form//

            $this->render("manage_news/add-edit");

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }          

    }
?>
