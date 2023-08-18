<section>
    <table>
        <tr>
            <td colspan="2" border="0">
                <center><b>PERSONAL INFORMATION</b></center>
            </td>
        </tr>
        <tr>
            <td colspan="2" border="0">
                <table>
                    <tr>
                        <td border="0" width="70" size='sm'>Name in Full</td>
                        <td border="0"> : </td>
                        <td class="input">{{ $user?->name }} </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td border="0">
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">Date of Birth</td>
                        <td border="0"> : </td>
                        <td class="input">{{ $user?->personal?->dob }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">Mother Tongue</td>
                        <td border="0"> : </td>
                        <td class="input">{{ $user?->personal?->motherTongue?->name ?? 'N/A' }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">Nationality</td>
                        <td border="0"> : </td>
                        <td class="input">{{ $user?->personal?->nationality?->name ?? 'N/A' }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">Caste</td>
                        <td border="0"> : </td>
                        <td class="input"> {{ $user?->personal?->caste?->name ?? 'N/A' }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">Marital Status</td>
                        <td border="0"> : </td>
                        <td class="input">{{ ucfirst($user?->personal?->marital_status ?? 'N/A') }}</td>
                    </tr>
                </table>
            </td>
            <td border="0">
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">Gender</td>
                        <td border="0"> : </td>
                        <td class="input">{{ ucfirst($user?->personal?->gender ?? 'N/A') }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">Place of Birth</td>
                        <td border="0"> : </td>
                        <td class="input">{{ $user?->personal?->birthPlace?->name ?? 'N/A' }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">Religion</td>
                        <td border="0"> : </td>
                        <td class="input"> {{ $user?->personal?->religion?->name ?? 'N/A' }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">Community</td>
                        <td border="0"> : </td>
                        <td class="input"> {{ $user?->personal?->community?->name ?? 'N/A' }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">Aadhaar No</td>
                        <td border="0"> : </td>
                        <td class="input">{{ $user?->adhar?->doc_number }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td border="0">
                <table>
                    <tr>
                        <td border="0" width="70" size="sm"> Permanent Address </td>
                    </tr>
                    <tr>
                        <td class="input">{{ $user?->personal?->permanent_address ?? 'N/A' }}</td>
                    </tr>
                </table>
            </td>
            <td border="0">
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">Contact Address </td>
                    </tr>
                    <tr>
                        <td class="input">{{ $user?->personal?->contact_address ?? 'N/A' }} </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td border="0" width="60%">
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">E-mail </td>
                        <td border="0"> : </td>
                        <td class="input">{{ $user?->email ?? 'N/A' }}</td>
                    </tr>
                </table>
            </td>
            <td border="0">
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">Land Line</td>
                        <td border="0"> : </td>
                        <td class="input">&nbsp; </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td border="0">
                <table>
                    <tr>
                        <td border="0" width="70" size="sm">PAN No</td>
                        <td border="0"> : </td>
                        <td class="input" height="30">{{ $user?->pancard?->doc_number }}</td>
                    </tr>
                </table>
            </td>
            <td border="0">
                <table>
                    <tr>
                        <td size="sm" style="border-bottom: 0 !important;border-right:0 !important"
                            border="dotted">
                            <center>Mobile No</center>
                        </td>
                        <td size="sm" style="border-bottom: 0 !important" border="dotted">
                            <center>WhatsApp No</center>
                        </td>
                    </tr>
                    <tr>
                        <td class="input" style="border-right:0 !important">
                            {{ $user?->personal?->phone_no ?? 'N/A' }}</td>
                        <td class="input">{{ $user?->personal?->whatsapp_no ?? 'N/A' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td border="dotted" size="sm">
                <center size="sm">TEACHING</center>
            </td>
            <td border="dotted" size="sm">
                <center size="sm">NON TEACHING</center>
            </td>
        </tr>
        <tr>
            <td border="0" width="60%">
                <table>
                    <tr>
                        <td border="0" width="80" size='sm'>Designation</td>
                        <td border="0"> : </td>
                        <td class="input">{{ $user?->position?->designation?->name ?? 'N/A' }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td border="0" width="80" size='sm'>Classes Handling</td>
                        <td border="0"> : </td>
                        <td class="input">{{ $user?->handlingClassNames?->handling_classes ?? 'N/A' }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td border="0" width="80" size='sm'>Subjects Handling</td>
                        <td border="0"> : </td>
                        <td class="input">{{ $user?->handlingSubjectNames?->handling_subjects ?? 'N/A' }}</td>
                    </tr>
                </table>
            </td>
            <td border="0">
                <table>
                    <tr>
                        <td border="0">
                            <table>
                                <tr>
                                    <td border="dotted" width="12" height="5">&nbsp; </td>
                                    <td border="0" size="sm">Sanitary Helper </td>
                                </tr>
                            </table>
                        </td>
                        <td border="0">
                            <table>
                                <tr>
                                    <td border="dotted" width="12" height="5">&nbsp; </td>
                                    <td border="0" size="sm">Watchman </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td border="0">
                            <table>
                                <tr>
                                    <td border="dotted" width="12" height="5">&nbsp; </td>
                                    <td border="0" size="sm">Driver </td>
                                </tr>
                            </table>
                        </td>
                        <td border="0">
                            <table>
                                <tr>
                                    <td border="dotted" width="12" height="5">&nbsp; </td>
                                    <td border="0" size="sm">Attender </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td border="0" colspan="2">
                            <table>
                                <tr>
                                    <td border="dotted" width="12" height="5"> </td>
                                    <td border="0" size="sm">Other
                                    <td width="100%" border="0"
                                        style="border-bottom: 1px black dotted !important">&nbsp;</td>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
     
    </table>
    <table>
        <tr>
            <td border="0">
                <table>
                    <tr>
                        <td border="0" width="70" size='sm'>Blood Group&nbsp;: </td>
                        <td class="input">{{ $user?->healthDetails?->bloog_group?->name ?? 'N/A' }}</td>
                    </tr>
                </table>
            </td>
            <td border="0">
                <table>
                    <tr>
                        <td border="0" width="70" size='sm'>Height (cm)&nbsp;:</td>
                        <td class="input">{{ $user?->healthDetails?->height ?? 'N/A' }}</td>
                    </tr>
                </table>
            </td>
            <td border="0">
                <table>
                    <tr>
                        <td border="0" width="70" size='sm'>Weight (Kg) &nbsp;:</td>
                        <td class="input">{{ $user?->healthDetails?->weight ?? 'N/A' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td border="0" size="sm" width="85">Disease / Allergy :</td>
            <td border="0" size="sm" width="110">
                <span border="dotted" size="sm" width="20">
                    @if ($user?->healthDetails?->disease_allergy)
                        <img src="https://web.whatsapp.com/img/c5a15be93e425dcb8a26b06645ad4574_w_184-64.png"
                            width="15" />
                    @else
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                </span>
                <span>Yes&nbsp;&nbsp;</span>
                <span border="dotted" size="sm" width="20">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                NO. If Yes
            </td>
            <td border="dotted" width="100%" size="sm">{{ $user?->healthDetails?->disease_allergy }}</td>
        </tr>
        <tr>
            <td border="0" size="sm" width="85">Differently Abled :</td>
            <td border="0" size="sm" width="110">
                <span border="dotted" size="sm" width="20">
                    @if ($user?->healthDetails?->differently_abled)
                        <img src="https://web.whatsapp.com/img/c5a15be93e425dcb8a26b06645ad4574_w_184-64.png"
                            width="15" />
                    @else
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                </span>
                <span>Yes&nbsp;&nbsp;</span>
                <span border="dotted" size="sm" width="20">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                NO. If Yes
            </td>
            <td border="dotted" width="100%" size="sm">{{ $user?->healthDetails?->differently_abled }}
            </td>
        </tr>
    </table>
    <br>
    <div>
        <small>Identification Mark :</small>
        <div border="dotted">&nbsp; 1. &nbsp;</div>
        <div border="dotted">&nbsp; 2. &nbsp;</div>
    </div>
    <hr>
    <center><small><u>For Office use</u> </small></center>
    <table>
        <tr>
            <td border="0">
                Date of Joining :
                <span class="input" border="dotted" size="sm"
                    width="20">{{ commonDateFormat($joining?->joining_date) }}</span>
            </td>
            <td border="0" style="text-align: right">
                Emp.Id:
                <span border="dotted" size="sm"
                    width="20">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </td>
        </tr>
    </table>
    <div style="page-break-before:always">&nbsp;</div>
    <center>LANGUAGES KNOWN</center>
    <br>
    <table style="border-collapse: collapse">
        <tr>
            <td border="dotted" size="sm"><center> To Read </center></td>
            <td border="dotted" size="sm"><center> To Write</center> </td>
            <td border="dotted" size="sm"><center> To Speak</center></td>
        </tr>
        <tr>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
        </tr>
    </table>
    <br>
    <center>ACADEMIC DETAILS </center>
    <br>
    <table style="border-collapse: collapse">
        <tr>
            <td border="dotted" size="sm"><center>S.N</center></td>
            <td border="dotted" size="sm"><center>Course</center></td>
            <td border="dotted" size="sm"><center>Completed</center></td>
            <td border="dotted" size="sm"><center>Board/Univ.</center></td>
            <td border="dotted" size="sm"><center>Year of Completion</center></td>
            <td border="dotted" size="sm"><center>Main Subject</center></td>
            <td border="dotted" size="sm"><center>Ancillary Subject</center></td>
        </tr>
        <tr>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
        </tr>
    </table>
    <br>
    <table style="border-collapse: collapse">
        <tr>
            <td border="dotted" size="sm"><center>S.N</center></td>
            <td border="dotted" size="sm"><center>Course</center></td>
            <td border="dotted" size="sm"><center>Completed</center></td>
            <td border="dotted" size="sm"><center>Board/Univ.</center></td>
            <td border="dotted" size="sm"><center>Year of Completion</center></td>
            <td border="dotted" size="sm"><center>Main Subject</center></td>
            <td border="dotted" size="sm"><center>Ancillary Subject</center></td>
        </tr>
        <tr>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
            <td border="dotted" size="sm">&nbsp;</td>
        </tr> 
    </table>
    <br>
    <table style="border-collapse: collapse;text-align:center">
        <tr><td colspan="7" border="dotted">Please circle the appropriate option</td></tr>
        <tr>
            <td border="dotted">Subject</td>
            <td border="dotted" colspan="6">Studied upto</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">Tamil </td>
            <td border="dotted" size="sm">X</td>
            <td border="dotted" size="sm">XII</td>
            <td border="dotted" size="sm">UG</td>
            <td border="dotted" size="sm">PG</td>
            <td border="dotted" size="sm">Higher</td>
            <td border="dotted" size="sm">NO</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">English </td>
            <td border="dotted" size="sm">X</td>
            <td border="dotted" size="sm">XII</td>
            <td border="dotted" size="sm">UG</td>
            <td border="dotted" size="sm">PG</td>
            <td border="dotted" size="sm">Higher</td>
            <td border="dotted" size="sm">NO</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">Maths </td>
            <td border="dotted" size="sm">X</td>
            <td border="dotted" size="sm">XII</td>
            <td border="dotted" size="sm">UG</td>
            <td border="dotted" size="sm">PG</td>
            <td border="dotted" size="sm">Higher</td>
            <td border="dotted" size="sm">NO</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">Science </td>
            <td border="dotted" size="sm">X</td>
            <td border="dotted" size="sm">XII</td>
            <td border="dotted" size="sm">UG</td>
            <td border="dotted" size="sm">PG</td>
            <td border="dotted" size="sm">Higher</td>
            <td border="dotted" size="sm">NO</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">Social Science </td>
            <td border="dotted" size="sm">X</td>
            <td border="dotted" size="sm">XII</td>
            <td border="dotted" size="sm">UG</td>
            <td border="dotted" size="sm">PG</td>
            <td border="dotted" size="sm">Higher</td>
            <td border="dotted" size="sm">NO</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">Hindi </td>
            <td border="dotted" size="sm">X</td>
            <td border="dotted" size="sm">XII</td>
            <td border="dotted" size="sm">UG</td>
            <td border="dotted" size="sm">PG</td>
            <td border="dotted" size="sm">Higher</td>
            <td border="dotted" size="sm">NO</td>
        </tr>
        <tr>
            <td border="dotted" size="sm">French</td>
            <td border="dotted" size="sm">X</td>
            <td border="dotted" size="sm">XII</td>
            <td border="dotted" size="sm">UG</td>
            <td border="dotted" size="sm">PG</td>
            <td border="dotted" size="sm">Higher</td>
            <td border="dotted" size="sm">NO</td>
        </tr>
    </table>
</section>