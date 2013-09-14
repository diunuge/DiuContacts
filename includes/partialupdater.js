CBL_PartialUpdater = Class.create();

CBL_PartialUpdater.update = function(url, obj, options) {
  if (options == null) {
    options = {};
  }
  if (obj.form != null) {
    options.parameters = Form.serialize(obj.form);
    if (obj.name != '') {
      if (options.parameters != '') {
        options.parameters += '&';
      }
      options.parameters += encodeURIComponent(obj.name) + '=' + encodeURIComponent(obj.value);
    }
  } else {
    options.parameters = Form.serialize(obj);
  }
  return new CBL_PartialUpdater(url, options);
}

CBL_PartialUpdater.liveUpdate = function(url, form, options) {
  var newParams = Form.serialize(form);
  if (form.__partialUpdater_oldParams == null) {
    form.__partialUpdater_oldParams = newParams;
  } else if (form.__partialUpdater_oldParams != newParams) {
    form.__partialUpdater_oldParams = newParams;
    CBL_PartialUpdater.update(url, form, options);
  }
}

CBL_PartialUpdater.updateContent = function(xml) {
  var updates = xml.getElementsByTagName('partialupdate');
  for (var i = 0; i < updates.length; i++) {
    var update = updates.item(i);
    var id = update.getAttribute('id');
    if (id == null) {
      alert('invalid xml (no id)');
    } else {
      var target = document.getElementById(id);
      if (target == null) {
        alert('could not find element: ' + id);
      } else {
        var data = eval('update.firstChild.nodeValue');
        if (data == null) {
          data = '';
        }
        target.innerHTML = data;
      }
    }
  }
}

CBL_PartialUpdater.prototype.extend(Ajax.Request.prototype).extend({
  initialize: function(url, options) {
    this.transport = Ajax.getTransport();
    this.setOptions(options);
    
    var onLoading = this.options.onLoading || Prototype.emptyFunction;
    this.options.onLoading = (function() {
      this.showSpinner(true);
      onLoading(this.transport);
    }).bind(this);
    
    var onComplete = this.options.onComplete || Prototype.emptyFunction;
    this.options.onComplete = (function() {
      this.options.onLoading = Prototype.emptyFunction;
      this.showSpinner(false);
      this.updateContent();
      onComplete(this.transport);
    }).bind(this);
    
    this.request(url);
  },
  updateContent: function() {
    if (! this.responseIsSuccess() || this.transport.responseXML == null) {
      alert(this.transport.responseText);
      return;
    }
    CBL_PartialUpdater.updateContent(this.transport.responseXML);
  },
  showSpinner: function(show) {
    if (this.options.spinnerId || this.options.spinnerImg) {
      var target = document.getElementById(this.options.spinnerId);
      if (target == null) {
        alert('could not find element: ' + this.options.spinnerId);
      } else {
        if (show) {
          if (! target.__partialUpdater_spinnerSrcBackup) {
            target.__partialUpdater_spinnerSrcBackup = target.src;
          }
          target.src = this.options.spinnerImg;
        } else {
          if (target.__partialUpdater_spinnerSrcBackup) {
            target.src = target.__partialUpdater_spinnerSrcBackup;
          }
        }
      }
    }
  }
});
