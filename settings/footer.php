    </div>
    <div id="popupback" class="popupback" onclick="closemenu()"></div>
    <div id="popupt" class="popup"></div>

    <!-- Popup d'une largeur moyenne -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" id="myModalContent">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- popup avec une grande largeur -->
    <div class="modal fade bs-example-modal-lg" id="myLargeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel"></h4>
                </div>
                <div class="modal-body" id="myLargeModalContent">

                </div>
                <div class="modalLarge-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- popup de notification -->
    <div id="statusPopup" class="statusPopup" role="alert">
        <button type="button" class="close" data-dismiss="statusMessage" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div id="statusMessage" style="display: flex;align-items: center;height: 100%;"></div>
    </div>

    <footer id="footerlp">
        <script type="text/javascript" src="/<?= FolderJs ?>/general.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="/<?= FolderJs ?>/bootstrap.js"></script>
    </footer>

  </body>
</html>
