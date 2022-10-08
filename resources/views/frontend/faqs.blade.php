@extends('layouts.app')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">
                    E-Warranty Registration
                </h1>
            </div>
            <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                   <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                             E-Warranty Registration
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Breadcrumb Section End -->
<section class="blog spad py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="single_post_text">
                    <div id="form-my-warranty-bg" style="box-shadow: 0px 0px 3px #ccc;padding-top:20px;padding-bottom:20px;border: 1px solid #ccc;">
        <form method="post" id="form-my-warranty" enctype="multipart/form-data" class="col-12 mt-4">

        <div class="form-row">
            <div class="col-md-6 p-4">
                    <div class="form-row">
                        <div class="col">
                            <span><strong>PERSONAL INFO</strong></span>
                        </div>
                        <div class="col">
                            <p>*Mandatory field
                        </p></div>
                    </div>
                    <div class="form-row">
                        <div class="col-xl-6 pt-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user" style="width: 16px;"></i></span></div><input class="form-control form-control-lg" type="text" placeholder="Name*" name="name">
                                
                            </div>
                        </div>
                        <div class="col-xl-6 pt-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-clock-o" style="width: 16px;"></i></span></div><input class="form-control form-control-lg" type="text" placeholder="Date of birth*(DD/MM/YY)" name="birth">
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-xl-12 pt-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope-o" style="width: 16px;"></i></span></div><input class="form-control form-control-lg" type="text" placeholder="Email address*" name="email">
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-xl-6 pt-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-phone" style="width: 16px;"></i></span></div><input class="form-control form-control-lg" type="text" placeholder="Contact number*(eg.012-3456789)" name="contact_number">
                                
                            </div>
                        </div>
                        <div class="col-xl-6 pt-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-list-alt" style="width: 16px;"></i></span></div><input class="form-control form-control-lg" type="text" placeholder="IC/passport number*" name="ic_number">
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-xl-12 pt-3"><textarea class="form-control form-control-lg form-control input-group" style="width: 100%;" rows="5" placeholder="Address*" type="text" name="address"></textarea></div>
                    </div>
                    <div class="form-row">
                        <div class="col pt-3">
                            <span><strong>PRODUCT INFO</strong></span>
                        </div>
                        <div class="col pt-3">
                            <span>*Mandatory field</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-xl-6 pt-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-shopping-cart" style="width: 16px;"></i></span></div><input class="form-control form-control-lg" type="text" placeholder="Retailer name*" name="retailer_name">
                                
                            </div>
                        </div>
                        <div class="col-xl-6 pt-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-clock-o" style="width: 16px;"></i></span></div><input class="form-control form-control-lg" type="text" placeholder="Date of purchase*(DD/MM/YY)" name="date_of_purchase">
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-xl-12 pt-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-wpforms" style="width: 16px;"></i></span></div><input class="form-control form-control-lg" type="text" placeholder="Model*(eg.LE-55F3G)" name="model">
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-xl-12 pt-3">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-barcode" style="width: 16px;"></i></span></div><input class="form-control form-control-lg" type="text" placeholder="Serial NO.*(eg.MYS123456789012345)" name="serial_number">
                                
                            </div>
                        </div>
                    </div>

            </div>

            <div class="col-md-6 p-4 border-left">
                <div class="form-row">
                    <div class="form-group col">
                        <div class="text-center" style="border: .2rem dashed #e8e8e8;">
                            <label for="file1 w-100 h-100" style="padding: 2rem;" id="file1_text"><i class="fa fa-file-photo-o"></i> Upload Your Receipt*</label>
                            <input type="file" name="file1" class="file opacity0 pointer form-my-warranty-file">
                        </div>
                    </div>
                </div>
               
                
               
                <div class="form-row">
                    <div class="form-group col">
                        <span>
                            By uploading your receipt &amp; screenshot of evidence, we hereby acknowledge that you have read, understand, and agree to the full terms and conditions of Caixun Malaysia Extended Warranty Campaign &amp; Monthly Campaign (If any).
                        </span>
                    </div>
                </div>


            </div>
        </div>
  
        
        </form>


          
        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
            <p style="line-height: 150%; text-align: center;">
    <span style="font-size: 24px;"><strong><span style="font-family: Arial; line-height: 150%;"><br></span></strong></span>
</p>
<p style="line-height: 150%; text-align: center;">
    <span style="font-size: 24px;"><strong><span style="font-family: Arial; line-height: 150%;">Conditions&nbsp; of&nbsp; Warranty</span></strong></span>
</p>
<p style="line-height:150%">
    <span style=";font-family:Arial;line-height:150%;font-size:13px">&nbsp;</span>
</p>
<p style="line-height:150%">
    <span style=";font-family:Arial;line-height:150%;font-size:13px">Caixun Malaysia Sdn Bhd (“Caixun”) will provide warranty to Original Buyer (“buyer”) upon buying&nbsp;Caixun product(s) (“product”). As such, buyer will be exempt from defect materials and workmanship under regular use. Buyer shall fix the defects through Caixun Authorised Service Centres.</span>
</p>
<p style="line-height:150%">
    <span style=";font-family:Arial;line-height:150%;font-size:13px">&nbsp;</span>
</p>
<p style="margin-left:24px;line-height:150%">
    <span style="font-family:Arial;font-weight:bold;font-size:13px">I.&nbsp;</span><strong><span style="font-family: Arial;line-height: 150%;font-size: 13px">Period &amp; terms and conditions of Caixun warranty:</span></strong>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">1.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">This Warranty applies only to Caixun product purchased through: -</span>
</p>
<p style="margin-left:96px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">a.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">&nbsp;Caixun Authorised reseller(s) in Malaysia or;</span>
</p>
<p style="margin-left:96px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">b.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">&nbsp;Caixun Authorised dealer(s) in Malaysia or; </span>
</p>
<p style="margin-left:96px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">c.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">&nbsp;Caixun Official Online Store(s)/ platform(s) in Malaysia.</span>
</p>
<p dir="ltr" style="margin-left: 48px; line-height: 150%; text-indent: 0em; text-align: left; margin-top: 5px; margin-bottom: 5px;">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">2.&nbsp;Warranty valid through registering online at&nbsp;&nbsp;<a href="http://www.caixun-global.com/my/"><span style="text-decoration:underline;"><span style="font-family: Arial;line-height: 150%;color: rgb(0, 0, 255);font-size: 13px">http://www.caixun-global.com/my/</span></span></a> and it must be from an authorized seller (mentioned in clause (1)) in Malaysia with purchasing date clearly stated. Caixun is not liable for any unclear information, lost of original purchasing receipt and whatsoever in the event of warranty claim needed. </span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">3.&nbsp;Buyer is advised to register their e-Warranty within 30 days from purchasing date based on original receipt from an authorized seller. Alternatively, buyer shall held responsibility in keeping their original purchasing receipt in the event of warranty claim needed.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">4.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Buyer shall take note that the warranty period starts based on product(s) purchasing date, not e-Warranty registered date. </span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">5.&nbsp;Caixun reserved the right to reject warranty claims or services, if there is no e-warranty registered, or no found of record on Caixun website, lost of original receipt, important information not recorded/ or written or unclear copies. </span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">6.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Warranty is valid in Malaysia only. </span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">7.&nbsp;In the event of defect of product, buyer need to contact Caixun thru sending e-mail or contact Caixun hotline as you may find on Caixun website <a href="http://www.caixun-global.com/my/"><span style="text-decoration:underline;"><span style="font-family: Arial;line-height: 150%;color: rgb(0, 0, 255);font-size: 13px">http://www.caixun-global.com/my/</span></span></a> or section (VI) of this Terms &amp; Conditions. </span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">8.&nbsp;If buyer choose to courier or forward Caixun product(s) for servicing at Caixun Authorized Service Centre, it should be under full insurance, well packed, clearly describe the defect or failing operation and prepaid transportation fee. Original purchasing receipt shall be attached together in the package (if any). Otherwise, e-Warranty record shall be evaluated by Caixun. </span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">9.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Kindly contact Caixun for e-Warranty checking before servicing. </span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">10.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">On-site service is available for all TV sizes. Kindly contact Caixun hotline or e-mail to require more information regarding this. </span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">11.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Buyer should bear in mind that product might took any longer time to be repaired or serviced due to part(s) availability. </span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">12.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Caixun is not liable directly or indirectly for financial losses or claims from third party resulting from failure of using the product or the use or loss of use of product.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">13.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Warranty of product is as specified below except for consumables, exterior cosmetics parts, appearance plastic parts, options, accessories, battery, and adaptor.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">14.&nbsp;Buyer is eligible to claim the warranty In the event of defect causes by manufacturing in material and workmanship and/ or malfunction during warranty period under normal use and condition and in compliance with Law of Malaysia.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">15.&nbsp;Permanent records which have important data related to product’s warranty is advisable to keep a copy by buyer in the event if the information or data might lose or change in any electronic memory product under particular situations. Caixun is not liable for any data lost or otherwise declared unusable as a result of static charge build-up, electronic noise from nearby appliances, improper use, repairs, defects, or any other cause.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">16.&nbsp;Caixun will not responsible for any data loss during repair procedure, as repair and verification procedure for certain components may result in cancellation of data and programs in the memories of products, so the saving data and program contained in the product is necessary.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">17.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Warranty is restricted to the expense of replacing the product with the same or equivalent product or repair of the product whichever is lower.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">18.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">After product repaired or replaced, only the remaining warranty will be applied.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">19.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Caixun reserves the right to replace the malfunction part(s) with same value or reconditioned part.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">20.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Caixun reserves the right to alter, cancel, extend, terminate or suspend the policy at its sole discretion without any prior notice.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style=";font-family:Arial;line-height:150%;font-size:13px">&nbsp;</span>
</p>
<p style="margin-left:24px;line-height:150%">
    <span style="font-family:Arial;font-weight:bold;font-size:13px">II.&nbsp;</span><strong><span style="font-family: Arial;line-height: 150%;font-size: 13px">Details of Product Warranty:</span></strong>
</p>
<p style="margin-left:24px;line-height:150%">
    <img src="http://caixun-global.oss-accelerate.aliyuncs.com/_OfficialSite/20210707/_ueditor.1625653439483867.png" title="1625653439483867.png" alt="image.png">
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">1.&nbsp;In the event buyer participated in “Caixun Extended Warranty” Campaign, kindly refer to “Caixun Extended Warranty” Campaign full terms and conditions on Caixun Official Website (<a href="http://www.caixun-global.com/my/"><span style="text-decoration:underline;"><span style="font-family: Arial;line-height: 150%;color: rgb(0, 0, 255);font-size: 13px">http://www.caixun-global.com/my/</span></span></a>) with regarding warranty coverage and any other relevant information. Extended warranty coverage may varies depends on the full terms and conditions applied.</span>
</p>
<p style="line-height:150%">
    <span style=";font-family:Arial;line-height:150%;font-size:13px">&nbsp;</span>
</p>
<p style="margin-left:24px;line-height:150%">
    <span style="font-family:Arial;font-weight:bold;font-size:13px">III.&nbsp;</span><strong><span style="font-family: Arial;line-height: 150%;font-size: 13px">This warranty is void and or not cover if the product is:</span></strong>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">1.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Over product warranty period whilst complying with the local Law requirements;</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">2.&nbsp;The product has been subjected to abnormal use, insufficient protection, improper storage, exposure to excessive moisture or dampness, exposure to excessive temperature (less-10º, equal or above 55º), unauthorized modification, unauthorized repair (including but not limited to use of unauthorized spare parts in repairs) ,abuse, tempered ,accidents, human damage, rust, Acts of God, spills of food or liquids etc;</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">3.&nbsp;In case of tampering, alteration, abrasion, deletion, removal of serial number found on product and its components and accessories; detachment, breaking, tampering or other violation of integrity of seals placed on the product by unauthorized person;</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">4.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">The product has been used with or connected to an accessory, component, device, equipment, programs etc:</span>
</p>
<p style="margin-left:96px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">a.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Not supplied by Caixun Malaysia or its affiliates;</span>
</p>
<p style="margin-left:96px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">b.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Not fit for use with the product or;</span>
</p>
<p style="margin-left:96px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">c.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Used otherwise than in manner intended.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">5.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">The failure be caused by viruses of any kind, or improper installation of software or software not provided by Caixun Malaysia; </span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">6.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">You have not notified Caixun Malaysia of the defect in the product during the applicable warranty period<span style="font-family:宋体">；</span><span style="font-family:Arial">Dysfunction of electricity grid;</span></span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">7.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Used in commercial application;</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">8.&nbsp;The member of which, by their nature or by normal wear, tear or decay, require periodic maintenance or replacement (the/ and power cables and structure components, subject to mechanical stress), by way of example and not exhaustive;</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">9.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">The product damaged during transportation when send to Caixun Malaysia or Authorized service provider or ASC for repair or after repaired return back to Customer;</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">10.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">The product has been painted or covered with some materials that affect its right functioning;</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">11.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Ordinary adjustment to the product which can be performed by customer as outlined in user manual;</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">12.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Failure to use the product in accordance with the instruction provided by Caixun Malaysia;</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">13.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Signal reception problems caused by external antenna or cable system;</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">14.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Serial number recorded on e-Warranty claimed or original purchasing receipt is different from buyer’s product;</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">15.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">insect’s infestation or pests invade or animal urine.</span>
</p>
<p style="margin-left:24px;line-height:150%">
    <span style=";font-family:Arial;line-height:150%;font-size:13px">&nbsp;</span>
</p>
<p style="margin-left:24px;line-height:150%">
    <span style="font-family:Arial;font-weight:bold;font-size:13px">IV.&nbsp;</span><strong><span style="font-family: Arial;line-height: 150%;font-size: 13px">Warranty not transferable:</span></strong>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">1.&nbsp;This warranty is not transferable and applies only to the original purchaser and does not extend to subsequent owners of the product. Any applicable implied warranties ,including the warranty of merchantability, are limited in duration to a period of the express warranty as provided herein beginning with the date of original purchase at seller and no warranties, whether express or implied shall apply to this product thereafter, Caixun Malaysia makes no warranty as to the fitness of the product for any particular purpose and use.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">2.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">This warranty was given by Caixun Malaysia if any item or right conflict with laws of Malaysia, the laws of Malaysia will be prevailed.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style=";font-family:Arial;line-height:150%;font-size:13px">&nbsp;</span>
</p>
<p style="margin-left:24px;line-height:150%">
    <span style="font-family:Arial;font-weight:bold;font-size:13px">V.&nbsp;</span><strong><span style="font-family: Arial;line-height: 150%;font-size: 13px">Force Majeure Event</span></strong>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">1.&nbsp;Force Majeure Event means an event or cause beyond the reasonable control of the party claiming force majeure including, without limitation, fire, flood, earthquake, elements of nature or acts of God, acts of war, terrorism, riots, civil discords, rebellions, or revolutions, strikes, country lockdown, riot, lockouts and any other relevant.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">2.&nbsp;Subject to clause (V)1, neither party will be liable for any default or delay in the performance, speed, arrangement of technical service and support by Caixun Malaysia under the conditions which is due to a Force Majeure Event.</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px"></span><span style=";font-family:Arial;line-height:150%;font-size:13px">3.&nbsp;a party who is unable to perform any of its obligations under the conditions because of a Force Majeure Event will be excused from performance or observance of the obligations affected by the Force Majeure Event for as long as the Force Majeure Event prevails. &nbsp;</span>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style=";font-family:Arial;line-height:150%;font-size:13px">&nbsp;</span>
</p>
<p style="margin-left:24px;line-height:150%">
    <span style="font-family:Arial;font-weight:bold;font-size:13px">VI.&nbsp;</span><strong><span style="font-family: Arial;line-height: 150%;font-size: 13px">For any others’ enquiries:</span></strong>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Calibri;font-size:13px">1.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">In the event of defect of product, kindly report the problem(s) via below e-mail or hotline:-</span>
</p>
<p style="margin-left:96px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">a.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">For Product/ Service Enquiry, please contact us at 03 – 5115 0515;</span>
</p>
<p style="margin-left:96px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">b.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">E-mail us at&nbsp;&nbsp; </span><a href="mailto:myservice@expressluck.com"><span style="text-decoration:underline;"><span style="font-family: Arial;line-height: 150%;color: rgb(0, 0, 255);font-size: 13px">myservice@expressluck.com</span></span></a><span style=";font-family:Arial;line-height:150%;font-size:13px">;</span>
</p>
<p style="margin-left:96px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">c.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">WhatsApp live chat us at +01 9335 0515 or;</span>
</p>
<p style="margin-left:96px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">d.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">Message us on our Official Facebook Page - <a href="https://www.facebook.com/CaixunMalaysia"><span style="text-decoration:underline;"><span style="font-family: Arial;line-height: 150%;color: rgb(0, 0, 255);font-size: 13px">@CaixunMalaysia</span></span></a></span>
</p>
<p style="line-height:150%">
    <span style=";font-family:Arial;line-height:150%;font-size:13px">&nbsp;</span>
</p>
<p style="margin-left:24px;line-height:150%">
    <span style="font-family:Arial;font-weight:bold;font-size:13px">VII.&nbsp;</span><strong><span style="font-family: Arial;line-height: 150%;font-size: 13px">E-Warranty Registration: </span></strong>
</p>
<p style="margin-left:48px;line-height:150%">
    <span style="font-family:Arial;font-size:13px">1.&nbsp;</span><span style=";font-family:Arial;line-height:150%;font-size:13px">You may register your e-Warranty with Caixun on &nbsp;</span><a href="http://www.caixun-global.com/my/"><span style="text-decoration:underline;"><span style="font-family: Arial;line-height: 150%;color: rgb(0, 0, 255);font-size: 13px">http://www.caixun-global.com/my/</span></span></a><span style=";font-family:Arial;line-height:150%;font-size:13px">.</span>
</p>
<p style="text-indent:24px;line-height:150%">
    <strong><em><span style="font-family: Arial;line-height: 150%;font-size: 13px">We thank you for your purchase of Caixun Malaysia Product. Hope you enjoy it.</span></em></strong>
</p>
<p>
    <br>
</p>
        </div>
</section>
@endsection