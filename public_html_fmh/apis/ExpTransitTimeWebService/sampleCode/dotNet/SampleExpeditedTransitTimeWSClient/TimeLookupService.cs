﻿//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated by a tool.
//     Runtime Version:4.0.30319.17929
//
//     Changes to this file may cause incorrect behavior and will be lost if
//     the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------



[System.CodeDom.Compiler.GeneratedCodeAttribute("System.ServiceModel", "4.0.0.0")]
[System.ServiceModel.ServiceContractAttribute(Namespace="http://time.odfl.com/", ConfigurationName="TimeLookupDelegate")]
public interface TimeLookupDelegate
{
    
    // CODEGEN: Parameter 'return' requires additional schema information that cannot be captured using the parameter mode. The specific attribute is 'System.Xml.Serialization.XmlElementAttribute'.
    [System.ServiceModel.OperationContractAttribute(Action="http://time.odfl.com/TimeLookupDelegate/getTTRequest", ReplyAction="http://time.odfl.com/TimeLookupDelegate/getTTResponse")]
    [System.ServiceModel.XmlSerializerFormatAttribute()]
    [return: System.ServiceModel.MessageParameterAttribute(Name="return")]
    getTTResponse getTT(getTTRequest request);
    
    [System.ServiceModel.OperationContractAttribute(Action="http://time.odfl.com/TimeLookupDelegate/getTTRequest", ReplyAction="http://time.odfl.com/TimeLookupDelegate/getTTResponse")]
    System.Threading.Tasks.Task<getTTResponse> getTTAsync(getTTRequest request);
}

/// <remarks/>
[System.CodeDom.Compiler.GeneratedCodeAttribute("svcutil", "4.0.30319.17929")]
[System.SerializableAttribute()]
[System.Diagnostics.DebuggerStepThroughAttribute()]
[System.ComponentModel.DesignerCategoryAttribute("code")]
[System.Xml.Serialization.XmlTypeAttribute(Namespace="http://time.odfl.com/")]
public partial class timeRequest
{
    
    private string billToAcctField;
    
    private string destZipField;
    
    private string orgZipField;
    
    private string pickUpDateYMDField;
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(Form=System.Xml.Schema.XmlSchemaForm.Unqualified, Order=0)]
    public string billToAcct
    {
        get
        {
            return this.billToAcctField;
        }
        set
        {
            this.billToAcctField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(Form=System.Xml.Schema.XmlSchemaForm.Unqualified, Order=1)]
    public string destZip
    {
        get
        {
            return this.destZipField;
        }
        set
        {
            this.destZipField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(Form=System.Xml.Schema.XmlSchemaForm.Unqualified, Order=2)]
    public string orgZip
    {
        get
        {
            return this.orgZipField;
        }
        set
        {
            this.orgZipField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(Form=System.Xml.Schema.XmlSchemaForm.Unqualified, Order=3)]
    public string pickUpDateYMD
    {
        get
        {
            return this.pickUpDateYMDField;
        }
        set
        {
            this.pickUpDateYMDField = value;
        }
    }
}

/// <remarks/>
[System.CodeDom.Compiler.GeneratedCodeAttribute("svcutil", "4.0.30319.17929")]
[System.SerializableAttribute()]
[System.Diagnostics.DebuggerStepThroughAttribute()]
[System.ComponentModel.DesignerCategoryAttribute("code")]
[System.Xml.Serialization.XmlTypeAttribute(Namespace="http://time.odfl.com/")]
public partial class timeResponse
{
    
    private string delvDateField;
    
    private string delvDayField;
    
    private string delvTimeField;
    
    private string destSrvCntrField;
    
    private string messageField;
    
    private string orgSrvCntrField;
    
    private bool successField;
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(Form=System.Xml.Schema.XmlSchemaForm.Unqualified, Order=0)]
    public string delvDate
    {
        get
        {
            return this.delvDateField;
        }
        set
        {
            this.delvDateField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(Form=System.Xml.Schema.XmlSchemaForm.Unqualified, Order=1)]
    public string delvDay
    {
        get
        {
            return this.delvDayField;
        }
        set
        {
            this.delvDayField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(Form=System.Xml.Schema.XmlSchemaForm.Unqualified, Order=2)]
    public string delvTime
    {
        get
        {
            return this.delvTimeField;
        }
        set
        {
            this.delvTimeField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(Form=System.Xml.Schema.XmlSchemaForm.Unqualified, Order=3)]
    public string destSrvCntr
    {
        get
        {
            return this.destSrvCntrField;
        }
        set
        {
            this.destSrvCntrField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(Form=System.Xml.Schema.XmlSchemaForm.Unqualified, Order=4)]
    public string message
    {
        get
        {
            return this.messageField;
        }
        set
        {
            this.messageField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(Form=System.Xml.Schema.XmlSchemaForm.Unqualified, Order=5)]
    public string orgSrvCntr
    {
        get
        {
            return this.orgSrvCntrField;
        }
        set
        {
            this.orgSrvCntrField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(Form=System.Xml.Schema.XmlSchemaForm.Unqualified, Order=6)]
    public bool success
    {
        get
        {
            return this.successField;
        }
        set
        {
            this.successField = value;
        }
    }
}

[System.Diagnostics.DebuggerStepThroughAttribute()]
[System.CodeDom.Compiler.GeneratedCodeAttribute("System.ServiceModel", "4.0.0.0")]
[System.ComponentModel.EditorBrowsableAttribute(System.ComponentModel.EditorBrowsableState.Advanced)]
[System.ServiceModel.MessageContractAttribute(WrapperName="getTT", WrapperNamespace="http://time.odfl.com/", IsWrapped=true)]
public partial class getTTRequest
{
    
    [System.ServiceModel.MessageBodyMemberAttribute(Namespace="http://time.odfl.com/", Order=0)]
    [System.Xml.Serialization.XmlElementAttribute(Form=System.Xml.Schema.XmlSchemaForm.Unqualified)]
    public timeRequest arg0;
    
    public getTTRequest()
    {
    }
    
    public getTTRequest(timeRequest arg0)
    {
        this.arg0 = arg0;
    }
}

[System.Diagnostics.DebuggerStepThroughAttribute()]
[System.CodeDom.Compiler.GeneratedCodeAttribute("System.ServiceModel", "4.0.0.0")]
[System.ComponentModel.EditorBrowsableAttribute(System.ComponentModel.EditorBrowsableState.Advanced)]
[System.ServiceModel.MessageContractAttribute(WrapperName="getTTResponse", WrapperNamespace="http://time.odfl.com/", IsWrapped=true)]
public partial class getTTResponse
{
    
    [System.ServiceModel.MessageBodyMemberAttribute(Namespace="http://time.odfl.com/", Order=0)]
    [System.Xml.Serialization.XmlElementAttribute(Form=System.Xml.Schema.XmlSchemaForm.Unqualified)]
    public timeResponse @return;
    
    public getTTResponse()
    {
    }
    
    public getTTResponse(timeResponse @return)
    {
        this.@return = @return;
    }
}

[System.CodeDom.Compiler.GeneratedCodeAttribute("System.ServiceModel", "4.0.0.0")]
public interface TimeLookupDelegateChannel : TimeLookupDelegate, System.ServiceModel.IClientChannel
{
}

[System.Diagnostics.DebuggerStepThroughAttribute()]
[System.CodeDom.Compiler.GeneratedCodeAttribute("System.ServiceModel", "4.0.0.0")]
public partial class TimeLookupDelegateClient : System.ServiceModel.ClientBase<TimeLookupDelegate>, TimeLookupDelegate
{
    
    public TimeLookupDelegateClient()
    {
    }
    
    public TimeLookupDelegateClient(string endpointConfigurationName) : 
            base(endpointConfigurationName)
    {
    }
    
    public TimeLookupDelegateClient(string endpointConfigurationName, string remoteAddress) : 
            base(endpointConfigurationName, remoteAddress)
    {
    }
    
    public TimeLookupDelegateClient(string endpointConfigurationName, System.ServiceModel.EndpointAddress remoteAddress) : 
            base(endpointConfigurationName, remoteAddress)
    {
    }
    
    public TimeLookupDelegateClient(System.ServiceModel.Channels.Binding binding, System.ServiceModel.EndpointAddress remoteAddress) : 
            base(binding, remoteAddress)
    {
    }
    
    [System.ComponentModel.EditorBrowsableAttribute(System.ComponentModel.EditorBrowsableState.Advanced)]
    getTTResponse TimeLookupDelegate.getTT(getTTRequest request)
    {
        return base.Channel.getTT(request);
    }
    
    public timeResponse getTT(timeRequest arg0)
    {
        getTTRequest inValue = new getTTRequest();
        inValue.arg0 = arg0;
        getTTResponse retVal = ((TimeLookupDelegate)(this)).getTT(inValue);
        return retVal.@return;
    }
    
    [System.ComponentModel.EditorBrowsableAttribute(System.ComponentModel.EditorBrowsableState.Advanced)]
    System.Threading.Tasks.Task<getTTResponse> TimeLookupDelegate.getTTAsync(getTTRequest request)
    {
        return base.Channel.getTTAsync(request);
    }
    
    public System.Threading.Tasks.Task<getTTResponse> getTTAsync(timeRequest arg0)
    {
        getTTRequest inValue = new getTTRequest();
        inValue.arg0 = arg0;
        return ((TimeLookupDelegate)(this)).getTTAsync(inValue);
    }
}