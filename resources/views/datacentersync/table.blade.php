 
 <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm">
                        <thead>
                            <tr class="text-uppercase">
                                <th>ชื่อแฟ้ม</th>
                                <th class="d-none d-xl-table-cell">Client</th>
                                <th class="d-none d-xl-table-cell">Datacenter</th>
                                <th class="d-none d-xl-table-cell">Acion</th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                                <td>
                                    <span class="font-w600">ทะเบียนครุภัณฑ์</span>
                                </td>
                                <td class="d-none d-xl-table-cell">
                                    <span id="client-asset" class="font-size-sm text-muted"></span>
                                </td>
                                <td>
                                    <span id="datacenter-asset" class="font-size-sm text-muted"></span>
                                </td>
                                 <td>
                                    <button class="btn btn-hero-sm btn-hero-primary" onclick="return getAsset()"><i id="icon-asset" class="fas fa-sync-alt"></i> ส่งข้อมูล</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="font-w600">ทะเบียนบุคลากร</span>
                                </td>
                                <td class="d-none d-xl-table-cell">
                                    <span id="client-person" class="font-size-sm text-muted"></span>
                                </td>
                                <td>
                                    <span id="datacenter-person" class="font-size-sm text-muted"></span>
                                </td>
                                 <td>
                                    <button class="btn btn-hero-sm btn-hero-primary" onclick="return getPerson()"><i id="icon-person" class="fas fa-sync-alt"></i> ส่งข้อมูล</button>
                                </td>
                            </tr>

                        </tbody>
                    </table>